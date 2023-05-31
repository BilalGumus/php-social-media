<div class="container mx-auto rounded">
    <div class="mx-auto">
        <div class="xl:w-1/2 w-11/12 mx-auto">
            <form class="mt-8 space-y-6" method="POST" enctype="multipart/form-data">
                <div class="rounded relative mt-8 h-48 mb-12">
                    <label for="banner-picture">
                        <?php if ($user_data["banner_picture"] == "default") { ?>
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
                            <img src="../assets/images/user/banner/<?php echo $user_data["banner_picture"]; ?>" alt="" class="w-full h-full object-cover absolute shadow rounded-t" />
                        <?php } ?>
                        <div class="absolute bg-black opacity-50 top-0 right-0 bottom-0 left-0 rounded"></div>
                        <div class="flex items-center px-3 py-2 rounded absolute right-0 mr-4 mt-4 cursor-pointer">
                            <p class="text-xs text-gray-100">Kapak Fotoğrafı</p>
                            <div class="ml-2 text-gray-100">
                                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_form-svg1.svg" alt="Edit">
                            </div>
                        </div>
                    </label>
                    <label for="profile-picture">
                        <div class="w-20 h-20 rounded-full bg-cover bg-center bg-no-repeat absolute bottom-0 -mb-10 ml-12 shadow flex items-center justify-center">
                            <?php if ($user_data["profile_picture"] == "default") { ?>
                                <div class="absolute w-20 h-20 overflow-hidden bg-indigo-100 rounded-full">
                                    <svg class="absolute text-indigo-500 w-24 h-24 -left-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            <?php
                            } else { ?>
                                <img src="../assets/images/user/profile/<?php echo $user_data["profile_picture"]; ?>" alt="" class="absolute z-0 h-full w-full object-cover rounded-full shadow top-0 left-0 bottom-0 right-0" />
                            <?php } ?>
                            <div class="absolute bg-black opacity-50 top-0 right-0 bottom-0 left-0 rounded-full z-0"></div>
                            <div class="cursor-pointer flex flex-col justify-center items-center z-10 text-gray-100">
                                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_form-svg1.svg" alt="Edit">
                                <p class="text-xs text-gray-100">Profil Resmi</p>
                            </div>
                        </div>
                    </label>
                </div>
                <input id="banner-picture" name="banner_picture" type="file" class="hidden" />
                <input id="profile-picture" name="profile_picture" type="file" class="hidden" />
                <div class="min-h-full flex items-center justify-center px-4">
                    <div class="max-w-md w-full space-y-8">
                        <?php echo (!empty($update_profile_success)) ? "<span class='mb-2 text-sm text-emerald-600'>$update_profile_success</span>" : "" ?>
                        <?php echo (!empty($profile_picture_err)) ? "<span class='mb-2 text-sm text-red-600'>$profile_picture_err</span>" : "" ?>
                        <?php echo (!empty($banner_picture_err)) ? "<span class='mb-2 text-sm text-red-600'>$banner_picture_err</span>" : "" ?>
                        <?php echo (!empty($update_profile_err)) ? "<span class='mb-2 text-sm text-red-600'>$update_profile_err</span>" : "" ?>
                        <div class="my-8 space-y-2">
                            <div class="flex flex-col">
                                <label for="username" class="pb-2 text-sm font-semibold text-gray-800">Kullanıcı Adı</label>
                                <input id="username" name="username" autocomplete="off" class="appearance-none relative block w-full px-3 py-2 focus:z-10 sm:text-sm rounded-md <?php echo (!empty($username_err)) ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 '; ?>" value="<?php echo $user_data["username"]; ?>" placeholder="Kullanıcı Adı" />
                                <span class="mt-2 text-sm text-red-600"><?php echo $username_err; ?></span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col w-50">
                                    <label for="first-name" class="pb-2 text-sm font-semibold text-gray-800">Ad</label>
                                    <input id="first-name" name="first_name" autocomplete="off" class="appearance-none relative block w-full px-3 py-2 focus:z-10 sm:text-sm rounded-md <?php echo (!empty($first_name_err)) ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 '; ?>" value="<?php echo $user_data["first_name"]; ?>" placeholder="Ad" />
                                    <span class="mt-2 text-sm text-red-600"><?php echo $first_name_err; ?></span>
                                </div>
                                <div class="flex flex-col">
                                    <label for="last-name" class="pb-2 text-sm font-semibold text-gray-800">Soyad</label>
                                    <input id="last-name" name="last_name" autocomplete="off" class="appearance-none relative block w-full px-3 py-2 focus:z-10 sm:text-sm rounded-md <?php echo (!empty($last_name_err)) ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 '; ?>" value="<?php echo $user_data["last_name"]; ?>" placeholder="Soyad" />
                                    <span class="mt-2 text-sm text-red-600"><?php echo $last_name_err; ?></span>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label for="email" class="pb-2 text-sm font-semibold text-gray-800">E-posta</label>
                                <input id="email" name="email" autocomplete="off" class="appearance-none relative block w-full px-3 py-2 focus:z-10 sm:text-sm rounded-md <?php echo (!empty($email_err)) ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 '; ?>" value="<?php echo $user_data["email"]; ?>" placeholder="E-posta" />
                                <span class="mt-2 text-sm text-red-600"><?php echo $email_err; ?></span>
                            </div>
                            <div class="flex flex-col">
                                <label for="new-password" class="pb-2 text-sm font-semibold text-gray-800">Yeni Şifre</label>
                                <input id="new-password" name="new_password" type="password" class="appearance-none relative block w-full px-3 py-2 focus:z-10 sm:text-sm rounded-md <?php echo (!empty($new_password_err)) ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 '; ?>" value="<?php echo $new_password; ?>" placeholder="Yeni Şifre" />
                                <span class="mt-2 text-sm text-red-600"><?php echo $new_password_err; ?></span>
                            </div>
                            <div class="flex flex-col">
                                <label for="confirm-new-password" class="pb-2 text-sm font-semibold text-gray-800">Yeni Şifre Tekrar</label>
                                <input id="confirm-new-password" name="confirm_new_password" type="password" class="appearance-none relative block w-full px-3 py-2 focus:z-10 sm:text-sm rounded-md <?php echo (!empty($confirm_new_password_err)) ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 '; ?>" value="<?php echo $confirm_new_password; ?>" placeholder="Yeni Şifre Tekrar" />
                                <span class="mt-2 text-sm text-red-600"><?php echo $confirm_new_password_err; ?></span>
                            </div>
                        </div>
                        <div class="container mx-auto w-11/12 xl:w-full">
                            <div class="w-full sm:px-0 bg-white flex justify-end">
                                <button role="button" class="bg-gray-200 focus:outline-none transition duration-150 ease-in-out hover:bg-gray-300 rounded text-indigo-600 px-6 py-2 text-xs mr-4 focus:ring-2 focus:ring-offset-2 focus:ring-gray-700">İptal Et</button>
                                <button type="submit" class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 bg-indigo-700 focus:outline-none transition duration-150 ease-in-out hover:bg-indigo-600 rounded text-white px-8 py-2 text-sm" type="submit">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>