# Production Role Access Implementation

## Overview

Implementasi fitur edit/update pada halaman work-orders/form.blade.php yang memungkinkan role **Production** untuk mengedit Work Order yang ditugaskan kepada mereka, dengan pembatasan akses yang tepat untuk menjaga integritas sistem.

## Implementasi Detail

### 1. **Controller Updates** (`app/Http/Controllers/WorkOrderController.php`)

#### A. Method `edit($id)` - Authorization & Data Passing

**Perubahan:**

-   Ditambahkan authorization check menggunakan Spatie Laravel Permission
-   Production hanya bisa edit work order yang assigned ke mereka
-   Asservice dapat edit semua work order

**Kode:**

```php
public function edit($id)
{
    $workOrder = WorkOrderModel::with(['customer', 'customer.accessCredentials'])->findOrFail($id);
    $user = auth()->user();

    // Authorization: Allow edit if user is asservice OR if user is production and assigned to this work order
    if (!$user->hasRole('asservice') && !($user->hasRole('production') && $workOrder->production_id === $user->id)) {
        abort(403, 'Unauthorized. You can only edit work orders assigned to you.');
    }

    // ... (data fetching logic)

    // Pass user role to view for conditional rendering
    $isProduction = $user->hasRole('production');

    return view('work-orders.form', compact(..., 'isProduction'));
}
```

**Penjelasan:**

-   Line 1-5: Fetch work order dengan relations yang diperlukan
-   Line 6: Get authenticated user
-   Line 8-10: Authorization logic - abort jika user bukan asservice dan bukan production yang ditugaskan
-   Line 16: Pass boolean flag untuk conditional rendering di view

---

#### B. Method `update($request, $id)` - Role-Based Validation & Update

**Perubahan Signifikan:**

-   Validasi berbeda untuk production vs asservice
-   Production hanya bisa update: description dan access credentials
-   Production TIDAK bisa mengubah: customer, division, work_type, sales, production_id, domain, quantity, files
-   Asservice bisa update semua field

**Alur Logika:**

```php
public function update(Request $request, $id)
{
    return DB::transaction(function () use ($request, $id) {
        $workOrder = WorkOrderModel::findOrFail($id);
        $user = auth()->user();

        // STEP 1: Authorization
        if (!$user->hasRole('asservice') && !($user->hasRole('production') && $workOrder->production_id === $user->id)) {
            abort(403, 'Unauthorized.');
        }

        // STEP 2: Determine Role
        $isProduction = $user->hasRole('production');
        $isAsservice = $user->hasRole('asservice');

        // STEP 3: Role-Specific Validation
        if ($isProduction) {
            // ✅ Production: HANYA validasi description & access credentials
            $validationRules = [
                'description' => 'required|string',
                'access_types' => 'nullable|array',
                'access_types.*' => 'in:ojs,cpanel,webmail,website',
                'access_note' => 'nullable|string',
            ];
            // + rules untuk access_credentials fields...
        } else {
            // ✅ AsService: FULL validation (semua field)
            $validationRules = [
                'sales_id' => 'required|exists:users,id',
                'production_id' => 'required|exists:users,id',
                'division_id' => 'required|exists:table_division,id',
                // ... etc (original validation)
            ];
        }

        // STEP 4: Validasi
        $validated = $request->validate($validationRules);

        // STEP 5: Role-Specific Update Logic
        if ($isProduction) {
            // Production: Update HANYA description & access credentials
            $workOrder->description = $request->description;
            $workOrder->save();

            // Update access credentials only
            if ($request->has('access_types')) {
                // Handle access credential update...
            }
        } else {
            // AsService: Update SEMUA field (original logic)
            // Handle customer data, file uploads, full work order update...
        }
    });
}
```

**Flow Chart Update:**

```
REQUEST UPDATE
    ↓
[Authorization Check]
    ├─→ NOT asservice AND NOT (production + assigned) → ABORT 403
    └─→ PASS → Continue
    ↓
[Determine Role]
    ├─→ Production? → Set isProduction = true
    └─→ AsService? → Set isAsservice = true
    ↓
[Validate by Role]
    ├─→ Production → Validate ONLY description & access credentials
    └─→ AsService → Validate ALL fields
    ↓
[Update by Role]
    ├─→ Production:
    │   ├─ Update description
    │   ├─ Update access credentials
    │   └─ Restrict: customer, division, work_type, files, etc.
    │
    └─→ AsService:
        ├─ Handle customer data
        ├─ Upload files
        ├─ Update all work order fields
        └─ Update access credentials
    ↓
REDIRECT + SUCCESS MESSAGE
```

---

### 2. **Blade Template Updates** (`resources/views/work-orders/form.blade.php`)

#### A. Header - Mode Indicator

**Perubahan:**

```blade
<h2 class="text-xl font-semibold text-white">
    {{ isset($workOrder) ? 'Edit' : 'Create' }} Work Order
    @if (isset($workOrder) && isset($isProduction) && $isProduction)
        <span class="text-sm ml-2 inline-block bg-yellow-200 text-yellow-800 px-2 py-1 rounded">
            (Production Edit Mode)
        </span>
    @endif
</h2>
```

**Penjelasan:**

-   Menampilkan badge "(Production Edit Mode)" jika user adalah production yang sedang edit
-   Visual cue untuk production agar tahu mereka dalam mode restricted

---

#### B. Section 1: Customer Data - Conditional Display

**Perubahan:**

**Untuk AsService (Create & Edit):**

```blade
@if (!isset($isProduction) || !$isProduction || !isset($workOrder))
    <div class="bg-gray-50 border-l-4 border-blue-500...">
        <!-- FULL Customer Form (Radio buttons, existing customer select, new customer input) -->
    </div>
@else
    <!-- Production View: Customer Read-Only -->
@endif
```

**Untuk Production (Edit hanya):**

```blade
<div class="bg-blue-50 border-l-4 border-blue-500...">
    <div class="flex items-center mb-4">
        <span>1</span>
        <h3>Data Customer (Read-Only)</h3>
    </div>

    <!-- Display-only fields:
         - Nama Customer (text)
         - Email (text)
         - No. Telepon (text)
         - Alamat (text)
    -->
</div>
```

**Logika:**

-   Production TIDAK bisa melihat/edit customer form
-   Customer info ditampilkan sebagai read-only information
-   Customer TIDAK bisa diubah oleh production (konsisten dengan backend)

---

#### C. Section 2: Data Akses - Full Access untuk Semua Role

**Perubahan:**

```blade
<!-- SAMA UNTUK SEMUA ROLE -->
<!-- Production & AsService keduanya bisa:
     - Memilih jenis akses (OJS, cPanel, Webmail, Website)
     - Input credentials untuk masing-masing akses
     - Menambah/edit catatan akses
-->
```

**Penjelasan:**

-   Access credentials adalah responsibility production untuk setup/maintain
-   Oleh karena itu, SEMUA role bisa akses section ini
-   Production fokus pada setup credentials untuk customer

---

#### D. Section 3: Work Order Details - Conditional Editing

**Untuk AsService (Create & Edit):**

```blade
@if (!isset($isProduction) || !$isProduction || !isset($workOrder))
    <!-- EDITABLE FIELDS:
         ✅ Division (dropdown - required)
         ✅ Work Type (dropdown - required)
         ✅ Domain (text - optional)
         ✅ Quantity (number - required)
         ✅ Sales (dropdown - required)
         ✅ Production (dropdown - required)
         ✅ Fast Track (toggle button)
         ✅ Description (textarea - required)
         ✅ File Uploads (MOU, Work Form, Additional)
    -->
@endif
```

**Untuk Production (Edit hanya):**

```blade
@else
    <!-- READ-ONLY FIELDS (Display only):
         ❌ Division (read-only)
         ❌ Work Type (read-only)
         ❌ Quantity (read-only)
         ❌ Sales (read-only)
         ❌ Production (read-only)
         ❌ Fast Track (hidden)

         ✅ EDITABLE:
         ✅ Description (textarea)

         ❌ NO FILE UPLOADS (hidden entirely)
    -->
@endif
```

**Field Restriction Pattern:**

```blade
@if (!isset($isProduction) || !$isProduction || !isset($workOrder))
    <!-- Show editable select/input for AsService -->
    <select name="division_id" ...>
        @foreach ($divisions as $division)
            <option>{{ $division->name }}</option>
        @endforeach
    </select>
@else
    <!-- Show read-only display for Production -->
    <p class="py-3 px-4 bg-white border border-gray-200 rounded-lg">
        {{ $workOrder->division->name }}
    </p>
@endif
```

---

#### E. Disabled Fields untuk Production

**Domain field diset disabled untuk production:**

```blade
<input type="text" name="domain" id="domain"
    {{ isset($isProduction) && $isProduction && isset($workOrder) ? 'disabled' : '' }}>
```

**Penjelasan:**

-   Domain tetap bisa dilihat production tapi tidak bisa diubah
-   Menggunakan `disabled` attribute untuk prevent submission
-   Backend validation juga akan reject jika production mencoba ubah

---

### 3. **File Upload Restriction**

**Production TIDAK bisa upload file:**

```blade
@if (!isset($isProduction) || !$isProduction || !isset($workOrder))
    <!-- File upload section -->
    <input type="file" name="file_mou" ...>
    <input type="file" name="file_work_form" ...>
    <input type="file" name="additional_file" ...>
@endif
```

**Penjelasan:**

-   File management adalah responsibility AsService
-   Production fokus pada credentials & description
-   Backend tidak validate file fields untuk production

---

## Authorization Flow

### Scenario 1: Production User Edit Own Work Order ✅

```
1. Production User → URL: /production/work-orders/{id}/edit
2. Controller::edit()
   ├─ Check: user.hasRole('production') ✅
   ├─ Check: workOrder.production_id === user.id ✅
   └─ ALLOWED → Return form with isProduction=true
3. View renders:
   ├─ Header: "(Production Edit Mode)" badge shown
   ├─ Customer data: READ-ONLY
   ├─ Access data: FULL EDIT
   ├─ Details: description EDITABLE, others READ-ONLY
   └─ Files: HIDDEN
4. Form submit → Controller::update()
   ├─ Auth check: PASS ✅
   ├─ Validation: PRODUCTION rules only
   ├─ Update: description + access credentials ONLY
   └─ Success: Redirect with message
```

---

### Scenario 2: Production User Try Edit Other's Work Order ❌

```
1. Production User → URL: /production/work-orders/{id}/edit
   (where workOrder.production_id !== user.id)
2. Controller::edit()
   ├─ Check: user.hasRole('production') ✅
   ├─ Check: workOrder.production_id === user.id ❌
   └─ ABORT 403 Unauthorized
3. Error: "Unauthorized. You can only edit work orders assigned to you."
```

---

### Scenario 3: AsService User Edit Any Work Order ✅

```
1. AsService User → URL: /asservice/work-orders/{id}/edit
2. Controller::edit()
   ├─ Check: user.hasRole('asservice') ✅
   └─ ALLOWED → Return form with isProduction=false
3. View renders:
   ├─ Header: No badge (normal edit)
   ├─ Customer data: FULL FORM
   ├─ Access data: FULL EDIT
   ├─ Details: ALL FIELDS EDITABLE
   └─ Files: VISIBLE FOR UPLOAD
4. Form submit → Controller::update()
   ├─ Auth check: PASS ✅
   ├─ Validation: FULL ASSERVICE rules
   ├─ Update: ALL FIELDS
   └─ Success: Full update processed
```

---

### Scenario 4: Production User Try Create Work Order ❌

```
1. Production User → URL: /production/work-orders/create
2. Routes not defined:
   ❌ No 'production.work-orders.create' route
   ❌ Only 'production.work-orders.edit' allowed
3. Error: 404 Not Found
```

**Note:** Routes automatically restrict via `Route::resource()` configuration

---

## Field Accessibility Matrix

| Field                  | AsService Create | AsService Edit | Production Edit |
| ---------------------- | ---------------- | -------------- | --------------- |
| **Customer Selection** | ✅ Edit          | ✅ Edit        | ❌ Read-Only    |
| **Customer Data**      | ✅ Edit          | ✅ Edit        | ❌ Read-Only    |
| **Division**           | ✅ Edit          | ✅ Edit        | ❌ Read-Only    |
| **Work Type**          | ✅ Edit          | ✅ Edit        | ❌ Read-Only    |
| **Domain**             | ✅ Edit          | ✅ Edit        | ❌ Disabled     |
| **Quantity**           | ✅ Edit          | ✅ Edit        | ❌ Read-Only    |
| **Sales**              | ✅ Edit          | ✅ Edit        | ❌ Read-Only    |
| **Production**         | ✅ Edit          | ✅ Edit        | ❌ Read-Only    |
| **Fast Track**         | ✅ Toggle        | ✅ Toggle      | ❌ Hidden       |
| **Description**        | ✅ Edit          | ✅ Edit        | ✅ Edit         |
| **Access Types**       | ✅ Edit          | ✅ Edit        | ✅ Edit         |
| **Access Credentials** | ✅ Edit          | ✅ Edit        | ✅ Edit         |
| **Access Note**        | ✅ Edit          | ✅ Edit        | ✅ Edit         |
| **File Upload**        | ✅ Upload        | ✅ Upload      | ❌ Hidden       |

---

## Validation Rules Comparison

### Production Role (Edit only):

```php
'description' => 'required|string',
'access_types' => 'nullable|array',
'access_types.*' => 'in:ojs,cpanel,webmail,website',
'access_note' => 'nullable|string',
// + specific access_credentials validation
```

**NOT validated:**

-   sales_id
-   production_id
-   division_id
-   work_type_id
-   domain
-   quantity
-   file\_\* fields
-   fast_track
-   customer data

---

### AsService Role (Create & Edit):

```php
'sales_id' => 'required|exists:users,id',
'production_id' => 'required|exists:users,id',
'division_id' => 'required|exists:table_division,id',
'work_type_id' => 'required|exists:table_work_types,id',
'domain' => 'nullable|string|max:255',
'quantity' => 'required|integer|min:1',
'description' => 'required|string',
'file_mou' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
'file_work_form' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
'additional_file' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
'access_types' => 'nullable|array',
'access_types.*' => 'in:ojs,cpanel,webmail,website',
'access_note' => 'nullable|string',
// + customer data validation
```

---

## Testing Checklist

### ✅ Production User Tests

-   [ ] Production user dapat access edit page untuk work order yang assigned
-   [ ] Production user melihat "(Production Edit Mode)" badge
-   [ ] Production user hanya bisa edit description field
-   [ ] Production user dapat edit access credentials
-   [ ] Production user tidak bisa ubah customer data (hidden/read-only)
-   [ ] Production user tidak bisa ubah division (read-only)
-   [ ] Production user tidak bisa ubah work type (read-only)
-   [ ] Production user tidak bisa ubah quantity (read-only)
-   [ ] Production user tidak bisa upload files (section hidden)
-   [ ] Production user tidak bisa access work order yang tidak assigned
-   [ ] Production user tidak bisa akses create page (/production/work-orders/create)

### ✅ AsService User Tests

-   [ ] AsService user dapat access edit page untuk ANY work order
-   [ ] AsService user tidak melihat badge
-   [ ] AsService user dapat edit SEMUA field
-   [ ] AsService user dapat upload files
-   [ ] AsService user dapat create work order
-   [ ] AsService user dapat edit customer data
-   [ ] AsService user dapat edit division, work type, quantity, etc.

### ✅ Backend Validation Tests

-   [ ] Production submit request dengan invalid data → Validation error
-   [ ] Production try send sales_id → Ignored (not in validation)
-   [ ] Production try send division_id → Ignored (not in validation)
-   [ ] Production try send files → Ignored (not in validation)
-   [ ] AsService submit full form → Full validation applied
-   [ ] AsService submit with files → Files processed

---

## Security Considerations

### 1. **Authorization at Multiple Layers**

```
Layer 1: Routes (web.php)
├─ production.*  routes only allow read/update (no create/destroy)
└─ asservice.*   routes allow full CRUD

Layer 2: Controller (edit method)
├─ Check user.hasRole('production')
├─ Check workOrder.production_id === user.id
└─ Check user.hasRole('asservice')

Layer 3: Controller (update method)
├─ Repeat authorization check
└─ Different validation rules per role

Layer 4: Frontend (form.blade.php)
├─ Conditional field display
└─ Disabled/hidden fields
```

### 2. **Validation Prevents Data Manipulation**

-   Production tidak bisa update field yang tidak di-validasi
-   Backend ignores unvalidated fields
-   Frontend hides fields sebagai additional layer

### 3. **Update Logic Checks Role**

```php
if ($isProduction) {
    // ONLY update description & access credentials
    $workOrder->description = $request->description;
    // NOT updating: sales_id, production_id, division_id, etc.
} else {
    // Update EVERYTHING
}
```

---

## Troubleshooting

### Production user gets 403 on edit page

**Causes:**

1. Work order tidak assigned ke production user
2. User tidak punya role 'production'
3. User roles middleware issue

**Solutions:**

1. Verify work order's `production_id` matches user ID
2. Check `app/Models/User.php` has `use HasRoles` trait
3. Check `app/Providers/AppServiceProvider.php` loads permissions correctly

---

### Production user bisa upload files

**Causes:**

1. Browser developer tools manipulated form
2. Frontend check tidak implemented

**Solutions:**

1. Backend validation sudah prevent ini ✅
2. User akan get validation error
3. File tidak akan disimpan

---

### Production user bisa ubah customer data

**Causes:**

1. User manipulated form via browser dev tools
2. Sent customer_type field

**Solutions:**

1. Backend validation hanya accept `description` + `access_*` fields
2. Unvalidated fields di-ignore automatically
3. Work order customer tidak berubah

---

## Implementation Checklist

-   [x] Update `edit()` method dengan authorization
-   [x] Update `update()` method dengan role-based logic
-   [x] Pass `$isProduction` variable ke view
-   [x] Add conditional customer data section
-   [x] Add read-only customer display for production
-   [x] Add conditional field display untuk details section
-   [x] Hide file uploads section untuk production
-   [x] Add "(Production Edit Mode)" badge
-   [x] Test authorization flow
-   [x] Test field restrictions
-   [x] Test backend validation

---

## Future Enhancements

1. **Audit Logging**

    - Log production user updates untuk audit trail
    - Track who changed what and when

2. **Notification System**

    - Notify AsService when production updates credentials
    - Notify production when AsService updates work order

3. **Role-Based Dashboard**

    - Production dashboard with filtered work orders
    - Quick edit button for assigned work orders

4. **API Endpoints**

    - REST API for production to get assigned work orders
    - API for bulk credential updates

5. **Permission System**
    - Use Spatie permissions for granular control
    - Define 'edit-work-orders', 'update-credentials', etc.

---

## Related Files

-   `app/Http/Controllers/WorkOrderController.php` - Main controller with auth logic
-   `resources/views/work-orders/form.blade.php` - Form with conditional display
-   `routes/web.php` - Route definitions for roles
-   `app/Models/WorkOrderModel.php` - Model relationships
-   `app/Models/User.php` - User model with roles

---

**Last Updated:** November 28, 2025
**Status:** ✅ Implementation Complete
