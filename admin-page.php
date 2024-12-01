<?php
function cpm_admin_page() {
    if (isset($_POST['save_product_categories'])) {
        $categories = array();

        if (!empty($_POST['category_name'])) {
            foreach ($_POST['category_name'] as $index => $name) {
                $category = array(
                    'name' => sanitize_text_field($name),
                    'products' => array()
                );

                if (!empty($_POST['product_name'][$index])) {
                    foreach ($_POST['product_name'][$index] as $product_index => $product_name) {
                        $category['products'][] = array(
                            'name' => sanitize_text_field($product_name),
                            'price' => sanitize_text_field($_POST['product_price'][$index][$product_index]),
                            'description' => sanitize_textarea_field($_POST['product_description'][$index][$product_index]),
                        );
                    }
                }

                $categories[] = $category;
            }
        }

        update_option('cpm_product_categories', $categories);
    }

    $categories = get_option('cpm_product_categories', array());

    ?>
    <div class="wrap">
        <h1>مدیریت دسته‌بندی‌ها و محصولات</h1>
        <form method="POST">
            <div id="cpm-categories">
                <?php foreach ($categories as $index => $category): ?>
                    <div class="category-item">
                        <label>نام دسته‌بندی:</label>
                        <input type="text" name="category_name[]" value="<?php echo esc_attr($category['name']); ?>" />
                        <button type="button" class="remove-category">حذف دسته‌بندی</button>
                        <div class="products">
                            <?php foreach ($category['products'] as $product): ?>
                                <div class="product-item">
                                    <input type="text" name="product_name[<?php echo $index; ?>][]" value="<?php echo esc_attr($product['name']); ?>" placeholder="نام محصول" />
                                    <input type="text" name="product_price[<?php echo $index; ?>][]" value="<?php echo esc_attr($product['price']); ?>" placeholder="قیمت" />
                                    <textarea name="product_description[<?php echo $index; ?>][]" placeholder="توضیحات"><?php echo esc_textarea($product['description']); ?></textarea>
                                    <button type="button" class="remove-product">حذف محصول</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="add-product">افزودن محصول</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-category">افزودن دسته‌بندی</button>
            <button type="submit" name="save_product_categories" class="button button-primary">ذخیره تغییرات</button>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('add-category').addEventListener('click', function () {
            const container = document.createElement('div');
            container.className = 'category-item';
            container.innerHTML = `
                <label>نام دسته‌بندی:</label>
                <input type="text" name="category_name[]" value="" />
                <button type="button" class="remove-category">حذف دسته‌بندی</button>
                <div class="products"></div>
                <button type="button" class="add-product">افزودن محصول</button>
            `;
            document.getElementById('cpm-categories').appendChild(container);
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-product')) {
                const productContainer = document.createElement('div');
                productContainer.className = 'product-item';
                productContainer.innerHTML = `
                    <input type="text" name="product_name[]" placeholder="نام محصول" />
                    <input type="text" name="product_price[]" placeholder="قیمت" />
                    <textarea name="product_description[]" placeholder="توضیحات"></textarea>
                    <button type="button" class="remove-product">حذف محصول</button>
                `;
                e.target.previousElementSibling.appendChild(productContainer);
            }

            if (e.target.classList.contains('remove-category')) {
                e.target.closest('.category-item').remove();
            }

            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-item').remove();
            }
        });
    });
    </script>
    <?php
}
?>
