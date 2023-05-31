<div class="bg-white drop-shadow-md rounded p-5 my-3">
    <div class="flex items-center gap-2">
        <a href="profile.php?user_id=<?php echo $comment_row["id"]; ?>">
            <?php if (isset($comment_row["profile_picture"]) && $comment_row["profile_picture"] == "default") { ?>
                <div class="relative w-8 h-8 overflow-hidden bg-indigo-100 rounded-md">
                    <svg class="absolute text-indigo-500 w-10 h-10 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            <?php
            } else { ?>
                <img src="../assets/images/user/profile/<?php echo $comment_row["profile_picture"]; ?>" alt="" class="w-8 h-8 rounded-md object-cover" />
            <?php } ?>
        </a>
        <a href="profile.php?user_id=<?php echo $comment_row["id"]; ?>" class="text-gray-800 text-base font-semibold"><?php echo $comment_row["first_name"] . " " . $comment_row["last_name"]; ?></a>
        <p class="text-gray-600 text-sm">@<?php echo $comment_row["username"] ?> · <?php echo time_elapsed_string($comment_row["post_comment_date"]) ?></p>
    </div>
    <div class="py-4">
        <?php echo $comment_row["post_comment_title"] ?>
    </div>
    <?php if (isset($comment_row["post_comment_image"]) && $comment_row["post_comment_image"] != "") { ?>
        <img src="../assets/images/comments/<?php echo $comment_row["post_comment_image"]; ?>" alt="" class="mb-4 w-full h-72 object-cover shadow rounded" />
    <?php
    } ?>
    <form method="POST">
        <div class="flex items-center cursor-pointer">
        <button type="submit" name="post_comment_like">
                <?php
                $isLikedQuery = "SELECT post_comment_review_type FROM post_comment_review WHERE post_comment_review_user_id = ? AND post_comment_review_post_comment_id = ?;";
                $stmt = $link->prepare($isLikedQuery);
                $stmt->bind_param("ii", $user_id, $comment_row["post_comment_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $post_comment_review_data = $result->fetch_assoc();
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer icon icon-tabler icon-tabler-heart hover:fill-indigo-600 <?php echo $post_comment_review_data["post_comment_review_type"] == 1 ? "fill-indigo-600 hover:text-indigo-600" : "" ?>" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.275" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                </svg>
            </button>
            <div class="font-bold px-2">
                <?php
                $likeCountQuery = "SELECT COUNT(*) as like_count FROM post_comment_review WHERE post_comment_review_post_comment_id = ? AND post_comment_review_type=1;";
                $stmt = $link->prepare($likeCountQuery);
                $stmt->bind_param("i", $comment_row["post_comment_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $like_count = $result->fetch_assoc();

                $dislikeCountQuery = "SELECT COUNT(*) as dislike_count FROM post_comment_review WHERE post_comment_review_post_comment_id = ? AND post_comment_review_type=-1;";
                $stmt = $link->prepare($dislikeCountQuery);
                $stmt->bind_param("i", $comment_row["post_comment_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $dislike_count = $result->fetch_assoc();

                echo $like_count["like_count"] - $dislike_count["dislike_count"];
                ?>
            </div>
            <button type="submit" name="post_comment_dislike">
                <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer icon icon-tabler icon-tabler-heart-broken hover:fill-indigo-600 <?php echo $post_comment_review_data["post_comment_review_type"] == -1 ? "fill-indigo-600 hover:text-indigo-600" : "" ?>" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.275" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                    <path d="M12 7l-2 4l4 3l-2 4v3" />
                </svg>
            </button>
            <input name="post_comment_id" class="hidden" value="<?php echo $comment_row["post_comment_id"]; ?>"></input>
        </div>
    </form>
</div>