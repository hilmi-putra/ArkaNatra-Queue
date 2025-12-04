#!/bin/bash
# DataTables Configuration Verification Script
# Jalankan di terminal untuk memverifikasi konfigurasi DataTables di production

echo "=================================="
echo "DataTables Configuration Check"
echo "=================================="
echo ""

# 1. Check file exists
echo "1️⃣  Checking file existence..."
if [ -f "public/js/global-datatables.js" ]; then
    echo "✅ File found: public/js/global-datatables.js"
else
    echo "❌ File NOT found: public/js/global-datatables.js"
    exit 1
fi

# 2. Check key configurations
echo ""
echo "2️⃣  Checking configuration..."

# Check paging is false
if grep -q "paging: false" public/js/global-datatables.js; then
    echo "✅ paging: false (CORRECT - Laravel handles pagination)"
else
    echo "❌ paging: NOT set to false (PROBLEM)"
fi

# Check searching is false
if grep -q "searching: false" public/js/global-datatables.js; then
    echo "✅ searching: false (CORRECT - Server-side search)"
else
    echo "❌ searching: NOT set to false (PROBLEM)"
fi

# Check lengthChange is false
if grep -q "lengthChange: false" public/js/global-datatables.js; then
    echo "✅ lengthChange: false (CORRECT - Laravel controls size)"
else
    echo "❌ lengthChange: NOT set to false (PROBLEM)"
fi

# Check ordering is true
if grep -q "ordering: true" public/js/global-datatables.js; then
    echo "✅ ordering: true (CORRECT - Sorting enabled)"
else
    echo "❌ ordering: NOT set to true (PROBLEM)"
fi

# Check responsive is true
if grep -q "responsive: true" public/js/global-datatables.js; then
    echo "✅ responsive: true (CORRECT - Mobile support)"
else
    echo "❌ responsive: NOT set to true (PROBLEM)"
fi

# 3. Check for problematic configurations
echo ""
echo "3️⃣  Checking for problematic settings..."

if grep -q "pageLength:" public/js/global-datatables.js | grep -v "^[[:space:]]*//"; then
    echo "⚠️  WARNING: pageLength found (may override pagination)"
else
    echo "✅ No pageLength override (CORRECT)"
fi

if grep -q "serverSide: true" public/js/global-datatables.js; then
    echo "❌ serverSide is TRUE (should be FALSE)"
else
    echo "✅ serverSide: false (CORRECT)"
fi

# 4. Table structure validation
echo ""
echo "4️⃣  Checking view structures..."

# Check work-orders views
for view in resources/views/work-orders/index.blade.php resources/views/work-orders/status/*.blade.php; do
    if [ -f "$view" ]; then
        # Check if view has links()
        if grep -q "{{ \$data->links() }}" "$view"; then
            echo "✅ $(basename $view) has Laravel pagination"
        else
            echo "⚠️  $(basename $view) may NOT have pagination"
        fi
    fi
done

# 5. Check for validation
echo ""
echo "5️⃣  Checking for validation function..."

if grep -q "function isTableStructureValid" public/js/global-datatables.js; then
    echo "✅ Table structure validation enabled"
else
    echo "⚠️  Table structure validation not found"
fi

echo ""
echo "=================================="
echo "✅ Verification Complete!"
echo "=================================="
echo ""
echo "🎯 Next Steps:"
echo "1. Open browser console (F12)"
echo "2. Go to any page with tables"
echo "3. Look for messages like '✅ DataTable berhasil diinisialisasi'"
echo "4. Test pagination - should NOT be blocked by DataTables"
echo "5. Test sorting - should work on all columns except Aksi"
echo ""
