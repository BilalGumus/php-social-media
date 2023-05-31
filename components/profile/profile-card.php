<div class="rounded relative mt-2 h-48 mb-12">
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
    <div class="w-20 h-20 rounded-full bg-cover bg-center bg-no-repeat absolute bottom-0 -mb-10 ml-12 shadow flex items-center justify-center">
        <?php if ($userData["profile_picture"] == "default") { ?>
            <div class="relative w-20 h-20 overflow-hidden bg-indigo-100 rounded-full">
                <svg class="absolute text-indigo-500 w-24 h-24 -left-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
        <?php
        } else { ?>
            <img src="../assets/images/user/profile/<?php echo $userData["profile_picture"]; ?>" alt="" class="absolute z-0 h-full w-full object-cover rounded-full shadow top-0 left-0 bottom-0 right-0" />
        <?php } ?>
    </div>
</div>
<div class="mx-12 flex items-center justify-between">
    <div>
        <div class="pb-2 text-base font-bold text-gray-800"><?php echo $userData["first_name"] . " " . $userData["last_name"]; ?> · <span class="pb-2 text-sm font-normal text-gray-800">@<?php echo $userData["username"]; ?></span></div>
        <div class="flex items-center text-sm gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.475" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <rect x="4" y="5" width="16" height="16" rx="2" />
                <line x1="16" y1="3" x2="16" y2="7" />
                <line x1="8" y1="3" x2="8" y2="7" />
                <line x1="4" y1="11" x2="20" y2="11" />
                <line x1="11" y1="15" x2="12" y2="15" />
                <line x1="12" y1="15" x2="12" y2="18" />
            </svg>
            <span><?php echo formatDateToTurkish($userData["user_date"]); ?> tarihinde katıldı.</span>
        </div>
    </div>
    <div>
        <?php
        if (($user_id == null || $user_id == "undefined") || (!($user_id == null || $user_id == "undefined") && ($user_id != $user_profile_id))) {
            $isFollowingQuery = "SELECT * FROM user_follow WHERE sender_id = ? AND receiver_id = ?;";
            $stmt = $link->prepare($isFollowingQuery);
            $stmt->bind_param("ii", $_SESSION["id"], $_GET["user_id"]);
            $stmt->execute();
            $isFollowing = $stmt->get_result();

            if ($isFollowing->num_rows < 1) { ?>
                <form method="POST">
                    <button name="follow_user" type="submit" class="border border-indigo-600 text-indigo-600 bg-white hover:text-white hover:bg-indigo-600 flex gap-2 items-center my-2 transition duration-150 ease-in-out rounded-full px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                        <span>Takip Et</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            <path d="M16 11h6m-3 -3v6" />
                        </svg>
                    </button>
                </form>
            <?php
            } else { ?>
                <form method="POST">
                    <button name="follow_user" type="submit" class="border border-indigo-600 text-white bg-indigo-700 hover:bg-indigo-600 flex gap-2 items-center my-2 transition duration-150 ease-in-out rounded-full px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                        <span>Takip Ediliyor</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            <path d="M16 11l2 2l4 -4" />
                        </svg>
                    </button>
                </form>
            <?php
            }
            ?>
        <?php } else { ?>
            <a href="./profile-edit.php" class="flex gap-2 items-center cursor-pointer text-sm leading-3 tracking-normal py-2 hover:text-indigo-700 focus:text-indigo-700 focus:outline-none">
                <span>Profili Düzenle</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                    <line x1="16" y1="5" x2="19" y2="8" />
                </svg>
            </a>
        <?php } ?>
    </div>
</div>
<div class="flex justify-between py-6 px-2 mx-12">
    <?php
    $postCountQuery = "SELECT COUNT(*) as total_post_count FROM post INNER JOIN users ON users.id = post.user_id WHERE users.id = ?;";
    $stmt = $link->prepare($postCountQuery);
    $stmt->bind_param("i", $user_profile_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $postCount = $result->fetch_assoc();

    $followingCountQuery = "SELECT COUNT(*) as total_following_count FROM user_follow WHERE user_follow.sender_id = ?;";
    $stmt = $link->prepare($followingCountQuery);
    $stmt->bind_param("i", $user_profile_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $followingCount = $result->fetch_assoc();

    $followerCountQuery = "SELECT COUNT(*) as total_follower_count FROM user_follow WHERE user_follow.receiver_id = ?";
    $stmt = $link->prepare($followerCountQuery);
    $stmt->bind_param("i", $user_profile_id);
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