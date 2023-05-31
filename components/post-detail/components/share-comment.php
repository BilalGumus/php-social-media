<form method="POST" enctype="multipart/form-data">
    <div class="mb-4 mt-10 flex flex-col items-start gap-2 w-full">
        <?php echo (!empty($share_comment_success)) ? "<span class='mb-2 text-sm text-emerald-600'>$share_comment_success</span>" : "" ?>
        <?php echo (!empty($post_comment_title_err)) ? "<span class='mb-2 text-sm text-red-600'>$post_comment_title_err</span>" : "" ?>
        <?php echo (!empty($post_comment_image_err)) ? "<span class='mb-2 text-sm text-red-600'>$post_comment_image_err</span>" : "" ?>
        <?php echo (!empty($share_comment_error)) ? "<span class='mb-2 text-sm text-red-600'>$share_comment_error</span>" : "" ?>
        <textarea id="post-comment-title" name="post_comment_title" class="w-full bg-transparent border border-gray-300 pl-3 py-3 shadow-sm rounded text-sm focus:outline-none focus:border-indigo-700 resize-none placeholder-gray-500 text-gray-600" placeholder="Bu post hakkında bir şeyler yaz..." rows="3"></textarea>
        <div class="w-full flex justify-between gap-2">
            <div class="relative flex items-center">
                <input name="post_comment_image" type="file" class="block w-full text-sm text-slate-500 file:cursor-pointer file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
            </div>
            <input name="post_id" class="hidden" value="<?php echo $row["post_id"]; ?>"></input>
            <button name="share_post_comment" type="submit" class="justify-self-end text-white my-2 bg-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 rounded-full px-6 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                Yorum yap
            </button>
        </div>
    </div>
</form>