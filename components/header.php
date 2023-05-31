<div class="h-full w-full">
    <nav class="w-full mx-auto bg-white">
        <div class="container justify-between h-16 flex items-center lg:items-stretch mx-auto">
            <div class="h-full flex items-center">
                <div aria-label="Home" role="img" class="mr-10 flex items-center">
                    <a href="/selcuk-sozluk/pages/index.php">
                        <h3 class="text-base text-gray-800 font-bold tracking-normal leading-tight ml-0 md:ml-3 lg:block">Selçuk Sözlük</h3>
                    </a>
                </div>
            </div>
            <div class="pr-12 h-full flex items-center">
                <div class="relative w-full">
                    <div class="text-gray-600 absolute ml-3 inset-0 m-auto w-4 h-4">
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/light_with_Grey_background-svg3.svg" alt="search">
                    </div>
                    <input class="border border-gray-100 focus:outline-none focus:border-indigo-700 w-full md:w-80 rounded text-sm text-gray-500 placeholder-gray-600 bg-gray-100 pl-8 py-2" type="text" placeholder="Selçuk Sözlük'te Ara..." />
                </div>
            </div>
            <div class="h-full flex items-center justify-end">
                <div class="w-full h-full flex items-center">
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        $user_id = $_SESSION["id"];

                        $userQuery = "SELECT * FROM users WHERE id = ?";
                        $stmt = $link->prepare($userQuery);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $user_data = $result->fetch_assoc();
                    ?>
                        <div class="w-full h-full flex">
                            <div x-data="{
                                open: false,
                                toggle() {
                                    if (this.open) {
                                        return this.close()
                                    }

                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                close(focusAfter) {
                                    if (! this.open) return

                                    this.open = false

                                    focusAfter && focusAfter.focus()
                                }
                            }" x-on:keydown.escape.prevent.stop="close($refs.button)" x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['dropdown-button']" class="cursor-pointer w-full flex items-center justify-end relative">
                                <button x-ref="button" x-on:click="toggle()" :aria-expanded="open" :aria-controls="$id('dropdown-button')" type="button" class="focus:outline-none rounded flex items-center">
                                    <?php if ($user_data["profile_picture"] == "default") { ?>
                                        <div class="relative w-10 h-10 overflow-hidden bg-indigo-100 rounded-full">
                                            <svg class="absolute w-12 h-12 text-indigo-500 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    <?php
                                    } else { ?>
                                        <img class="rounded-full h-10 w-10 object-cover" src="../assets/images/user/profile/<?php echo $user_data["profile_picture"]; ?>" alt="avatar" />
                                    <?php } ?>
                                    <p class="text-gray-800 text-sm ml-2 hidden sm:block"><?php echo $user_data["first_name"] . " " . $user_data["last_name"]; ?></p>
                                </button>

                                <div x-ref="panel" x-show="open" x-transition.origin.top.left x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')" style="display: none;" class="absolute top-16 z-10 bg-white divide-y divide-gray-100 rounded shadow w-44">
                                    <ul class="py-1 px-2 text-sm text-gray-700" aria-labelledby="dropdownDefault">
                                        <a href="index.php">
                                            <li class="cursor-pointer text-gray-600 text-sm leading-3 tracking-normal py-2 hover:text-indigo-700 focus:text-indigo-700 focus:outline-none">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <polyline points="5 12 3 12 12 3 21 12 19 12" />
                                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                                    </svg>
                                                    <span class="ml-2">Ana Sayfa</span>
                                                </div>
                                            </li>
                                        </a>
                                        <a href="profile.php?user_id=<?php echo $user_data["id"]; ?>">
                                            <li class="cursor-pointer text-gray-600 text-sm leading-3 tracking-normal py-2 hover:text-indigo-700 focus:text-indigo-700 focus:outline-none">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" />
                                                        <circle cx="12" cy="7" r="4" />
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    </svg>
                                                    <span class="ml-2">Profil</span>
                                                </div>
                                            </li>
                                        </a>
                                        <a href="../scripts/logout.php">
                                            <li class="cursor-pointer text-gray-600 text-sm leading-3 tracking-normal py-2 hover:text-indigo-700 focus:text-indigo-700 focus:outline-none">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                                        <path d="M7 12h14l-3 -3m0 6l3 -3" />
                                                    </svg>
                                                    <span class="ml-2">Çıkış Yap</span>
                                                </div>
                                            </li>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="flex items-center gap-2">
                            <a href="sign-in.php">
                                <button role="button" class="h-10 min-w-fit bg-gray-200 focus:outline-none transition duration-150 ease-in-out hover:bg-gray-300 rounded text-indigo-600 px-6 py-2 mr-4 focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 text-sm">Giriş Yap</button>
                            </a>
                            <a href="sign-up.php">
                                <button role="button" class="h-10 min-w-fit focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 bg-indigo-700 focus:outline-none transition duration-150 ease-in-out hover:bg-indigo-600 rounded text-white px-8 py-2 text-sm">Kayıt Ol</button>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
</div>