<div class="container mx-auto flex flex-row flex-wrap gap-2">
    <a href="?category_id=0" class="flex justify-center items-center my-1 font-medium py-1 px-2 rounded-full cursor-pointer border <?php echo ($category_id == 0) ? "bg-indigo-400 border-indigo-400 text-white" : "text-gray-700 bg-indigo-100 border-indigo-300" ?>">
        <div class="text-xs font-normal leading-none max-w-full flex-initial">Tüm Kategoriler</div>
    </a>
    <?php
    $categoryQuery = "SELECT * FROM category";
    $categoryList = $link->query($categoryQuery);

    if ($categoryList->num_rows > 0) {
        while ($row = $categoryList->fetch_assoc()) { ?>
            <a href="?category_id=<?php echo $row["category_id"]; ?>" class="flex justify-center items-center my-1 font-medium py-1 px-2 rounded-full cursor-pointer border <?php echo ($category_id == $row["category_id"]) ? "bg-indigo-400 border-indigo-400 text-white" : "text-gray-700 bg-indigo-100 border-indigo-300" ?>">
                <div class="text-xs font-normal leading-none max-w-full flex-initial"><?php echo ucfirst($row["category_title"]); ?></div>
            </a>
    <?php }
    } ?>
</div>