<div class="bg-white drop-shadow-md rounded p-5 my-3">
    <div class="flex items-center gap-2">
        <a href="profile.php?user_id=<?php echo $row["id"]; ?>">
            <?php if (isset($row["profile_picture"]) && $row["profile_picture"] == "default") { ?>
                <div class="relative w-8 h-8 overflow-hidden bg-indigo-100 rounded-md">
                    <svg class="absolute text-indigo-500 w-10 h-10 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            <?php
            } else { ?>
                <img src="../assets/images/user/profile/<?php echo $row["profile_picture"]; ?>" alt="" class="w-8 h-8 rounded-md object-cover" />
            <?php } ?>
        </a>
        <a href="profile.php?user_id=<?php echo $row["id"]; ?>" class="text-gray-800 text-base font-semibold"><?php echo $row["first_name"] . " " . $row["last_name"]; ?></a>
        <p class="text-gray-600 text-sm">@<?php echo $row["username"] ?> · <?php echo time_elapsed_string($row["post_date"]) ?></p>
    </div>
    <a href="post.php?post_id=<?php echo $row["post_id"]; ?>">
        <div class="py-4">
            <?php echo $row["post_title"] ?>
        </div>
    </a>
    <a href="?category_id=<?php echo $row["category_id"]; ?>" class="text-indigo-600 text-base font-semibold">#<?php echo $row["category_title"] ?></a>
    <?php if (isset($row["post_image"]) && $row["post_image"] != "") { ?>
        <a href="post.php?post_id=<?php echo $row["post_id"]; ?>">
            <img src="../assets/images/post/<?php echo $row["post_image"]; ?>" alt="" class="w-full h-72 object-cover shadow rounded mt-4" />
        </a>
    <?php
    } ?>
    <div class="flex mt-4">
        <form method="POST">
            <div class="flex items-center cursor-pointer">
                <button type="submit" name="post_like">
                    <?php
                    $isLikedQuery = "SELECT post_review_type FROM post_review WHERE post_review_user_id = ? AND post_review_post_id = ?;";
                    $stmt = $link->prepare($isLikedQuery);
                    $stmt->bind_param("ii", $user_id, $row["post_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $post_review_data = $result->fetch_assoc();
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer icon icon-tabler icon-tabler-heart hover:fill-indigo-600 <?php echo $post_review_data["post_review_type"] == 1 ? "fill-indigo-600 hover:text-indigo-600" : "" ?>" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.275" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                    </svg>
                </button>
                <div class="font-bold px-2">
                    <?php
                    $likeCountQuery = "SELECT COUNT(*) as like_count FROM post_review WHERE post_review_post_id = ? AND post_review_type=1;";
                    $stmt = $link->prepare($likeCountQuery);
                    $stmt->bind_param("i", $row["post_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $like_count = $result->fetch_assoc();

                    $dislikeCountQuery = "SELECT COUNT(*) as dislike_count FROM post_review WHERE post_review_post_id = ? AND post_review_type=-1;";
                    $stmt = $link->prepare($dislikeCountQuery);
                    $stmt->bind_param("i", $row["post_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $dislike_count = $result->fetch_assoc();

                    echo $like_count["like_count"] - $dislike_count["dislike_count"];
                    ?>
                </div>
                <button type="submit" name="post_dislike">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer icon icon-tabler icon-tabler-heart-broken hover:fill-indigo-600 <?php echo $post_review_data["post_review_type"] == -1 ? "fill-indigo-600 hover:text-indigo-600" : "" ?>" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.275" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                        <path d="M12 7l-2 4l4 3l-2 4v3" />
                    </svg>
                </button>
                <input name="post_id" class="hidden" value="<?php echo $row["post_id"]; ?>"></input>
            </div>
        </form>
        <div class="flex items-center ml-8 cursor-pointer hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.275" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4" />
                <line x1="8" y1="9" x2="16" y2="9" />
                <line x1="8" y1="13" x2="14" y2="13" />
            </svg>
            <?php
            $postCommentCountQuery = " SELECT COUNT(*) AS post_comment_count FROM post INNER JOIN post_comment ON post_id = post_comment.post_comment_post_id WHERE post_id = ? GROUP BY post_comment_post_id;";
            $stmt = $link->prepare($postCommentCountQuery);
            $stmt->bind_param("i", $row["post_id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $post_comment_count = $result->fetch_assoc();
            ?>
            <a href="post.php?post_id=<?php echo $row["post_id"]; ?>" class="text-sm px-1"><?php echo (!$result->num_rows) ? "0" : $post_comment_count["post_comment_count"]; ?> yorum</a>
        </div>
    </div>
</div>