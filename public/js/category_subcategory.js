function updateSubcategories() {
    var categoryId = document.getElementById('category').value;
    var subcategorySelect = document.getElementById('subcategory');
    var subcategories = JSON.parse('<?php echo json_encode($subcategories); ?>');
    var filteredSubcategories = subcategories.filter(function (subcategory) {
        return subcategory.category_id == categoryId;
    });

    subcategorySelect.innerHTML = '';

    for (var i = 0; i < filteredSubcategories.length; i++) {
        var option = document.createElement('option');
        option.value = filteredSubcategories[i].id;
        option.text = filteredSubcategories[i].name;
        subcategorySelect.add(option);
    }
}
