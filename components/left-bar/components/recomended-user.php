<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION["id"];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['follow_recomended_user'])) {
        $isFollowingQuery = "SELECT * FROM user_follow WHERE sender_id = ? AND receiver_id = ?;";
        $stmt = $link->prepare($isFollowingQuery);
        $stmt->bind_param("ii", $user_id, $_POST["receiver_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            $query = "INSERT INTO user_follow (sender_id, receiver_id) values(?,?);";
            $stmt = $link->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ii", $user_id, $_POST["receiver_id"]);
                $stmt->execute();
            }
        } else {
            $query = "DELETE FROM user_follow WHERE sender_id = ? AND receiver_id = ?;";
            $stmt = $link->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ii", $user_id, $_POST["receiver_id"]);
                $stmt->execute();
            }
        }
    }
}
?>
<div class="bg-white drop-shadow-md rounded px-4 py-6">
    <span class="text-base font-semibold ml-1">Senin İçin Önerilenler</span>
    <div class="flex flex-col gap-2 mt-3">
        <?php
        $recomendedUserQuery = "SELECT * FROM users WHERE NOT id IN(SELECT receiver_id FROM user_follow WHERE sender_id = ?) AND id != ? LIMIT 3;";
        $stmt = $link->prepare($recomendedUserQuery);
        $stmt->bind_param("ii", $_SESSION["id"], $_SESSION["id"]);
        $stmt->execute();
        $all_recomended_user = $stmt->get_result();

        if (!($all_recomended_user->num_rows < 1)) {
            while ($row = $all_recomended_user->fetch_assoc()) { ?>
                <a href="profile.php?user_id=<?php echo $row["id"] ?>" class="flex justify-between items-center gap-4 hover:bg-indigo-50 px-2">
                    <div class="flex justify-between items-center gap-4">
                        <?php if ($row["profile_picture"] == "default") { ?>
                            <div class="relative w-10 h-10 overflow-hidden bg-indigo-100 rounded-full">
                                <svg class="absolute w-12 h-12 text-indigo-500 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        <?php
                        } else { ?>
                            <img class="rounded-full h-10 w-10 object-cover" src="../assets/images/user/profile/<?php echo $row["profile_picture"]; ?>" alt="avatar" />
                        <?php } ?>
                        <div class="flex flex-col py-1">
                            <span class="text-base font-semibold"><?php echo $row["first_name"] . " " . $row["last_name"]; ?></span>
                            <span class="text-gray-700 text-sm">@<?php echo $row["username"]; ?></span>
                        </div>
                    </div>
                    <div>
                        <form method="POST">
                            <input name="receiver_id" class="hidden" value="<?php echo $row["id"]; ?>"></input>
                            <button name="follow_recomended_user" type="submit" class="border border-indigo-600 text-indigo-600 bg-white hover:text-white hover:bg-indigo-600 flex gap-2 items-center transition duration-150 ease-in-out rounded-full py-2 px-4 text-xs focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                <span>Takip Et</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 11h6m-3 -3v6" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </a>
            <?php }
        } else { ?>
            <div class="pb-2 pt-8 text-sm text-center">Hmm. Herkesi takip etmişsin gibi duruyor.</div>
        <?php } ?>
    </div>
</div>