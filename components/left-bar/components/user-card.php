<div class="bg-white drop-shadow-md rounded">
    <div class="relative h-24 mb-10">
        <?php if ($userData["banner_picture"] == "default") { ?>
            <div class="w-full h-full absolute rounded-t bg-indigo-100 flex justify-center items-center text-indigo-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-off" width="36" height="36" viewBox="0 0 24 24" stroke-width="1" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="3" y1="3" x2="21" y2="21" />
                    <line x1="15" y1="8" x2="15.01" y2="8" />
                    <path d="M19.121 19.122a3 3 0 0 1 -2.121 .878h-10a3 3 0 0 1 -3 -3v-10c0 -.833 .34 -1.587 .888 -2.131m3.112 -.869h9a3 3 0 0 1 3 3v9" />
                    <path d="M4 15l4 -4c.928 -.893 2.072 -.893 3 0l5 5" />
                    <path d="M16.32 12.34c.577 -.059 1.162 .162 1.68 .66l2 2" />
                </svg>
            </div>
        <?php
        } else { ?>
            <img src="../assets/images/user/banner/<?php echo $userData["banner_picture"]; ?>" alt="" class="w-full h-full object-cover absolute shadow rounded-t" />
        <?php } ?>
        <a href="profile.php?user_id=<?php echo $userData["id"]; ?>">
            <div class="w-16 h-16 rounded-full bg-cover bg-center bg-no-repeat absolute left-1/2 -translate-x-1/2 bottom-0 -mb-8 shadow flex items-center justify-center">
                <?php if ($userData["profile_picture"] == "default") { ?>
                    <div class="relative w-16 h-16 overflow-hidden bg-indigo-100 rounded-full">
                        <svg class="absolute text-indigo-500 w-20 h-20 -left-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                <?php
                } else { ?>
                    <img src="../assets/images/user/profile/<?php echo $userData["profile_picture"]; ?>" alt="" class="absolute z-0 h-full w-full object-cover rounded-full shadow top-0 left-0 bottom-0 right-0" />
                <?php } ?>
            </div>
        </a>
    </div>
    <div class="text-center">
        <h3 class="text-base text-gray-800 font-bold"><?php echo $userData["first_name"] . " " . $userData["last_name"]; ?></h3>
        <p class="text-sm text-gray-800">@<?php echo $userData["username"]; ?></p>
    </div>
    <div class="flex justify-between p-3">
        <?php
        $postCountQuery = "SELECT COUNT(*) as total_post_count FROM post INNER JOIN users ON users.id = post.user_id WHERE users.id = ?;";
        $stmt = $link->prepare($postCountQuery);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $postCount = $result->fetch_assoc();

        $followingCountQuery = "SELECT COUNT(*) as total_following_count FROM user_follow WHERE user_follow.sender_id = ?;";
        $stmt = $link->prepare($followingCountQuery);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $followingCount = $result->fetch_assoc();

        $followerCountQuery = "SELECT COUNT(*) as total_follower_count FROM user_follow WHERE user_follow.receiver_id = ?";
        $stmt = $link->prepare($followerCountQuery);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $followerCount = $result->fetch_assoc();
        ?>
        <div class="flex flex-col text-center">
            <h3 class="text-sm text-gray-800 font-bold"><?php echo $postCount["total_post_count"]; ?></h3>
            <p class="text-sm text-gray-800">Post</p>
        </div>
        <div class="flex flex-col text-center">
            <h3 class="text-sm text-gray-800 font-bold"><?php echo $followingCount["total_following_count"]; ?></h3>
            <p class="text-sm text-gray-800">Takip Edilen</p>
        </div>
        <div class="flex flex-col text-center">
            <h3 class="text-sm text-gray-800 font-bold"><?php echo $followerCount["total_follower_count"]; ?></h3>
            <p class="text-sm text-gray-800">Takipçi</p>
        </div>
    </div>
</div>