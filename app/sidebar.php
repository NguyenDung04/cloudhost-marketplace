<div class="startbar d-print-none">
        <div class="brand">
            <a href="/home" class="logo">
                <span>
                    <img src="<?=$ketnoi->site('favicon');?>" alt="logo-small" class="logo-sm">
                </span>
                <span class="logo">
                    <img src="<?=$ketnoi->site('logo');?>" alt="logo-large" class="logo-lg logo-light">
                    <img src="<?=$ketnoi->site('logo');?>" alt="logo-large" class="logo-lg logo-dark">
                </span>
            </a>
        </div>
        <div class="startbar-menu" >
            <div class="startbar-collapse" id="startbarCollapse" >
                <div class="d-flex align-items-start flex-column w-100">
                    <ul class="navbar-nav mb-auto w-100">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="/home">
                                <img src="/core/upload/images/home.gif" height="25px" alt="" class="me-2">
                                <span>Trang Chủ</span>
                            </a>
                        </li>
                        
                        <li class="menu-label mt-2">
                            <span>Đăng Ký Dịch Vụ</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="/client/chat-ai">
                                <img src="/core/upload/images/ai.gif" height="25px" alt="" class="me-2">
                                <span>Chat Với AI</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="#vps" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="vps"> 
                                <img src="/core/upload/images/cloud.gif" height="25px" alt="" class="me-2"> 
                                <!-- <i class="fa-solid fa-table-columns menu-icon"></i>                                        -->
                                <span>Server Cloud</span>
                            </a>
                            <div class="collapse " id="vps">
                                <ul class="nav flex-column">
                                    <!-- <li class="nav-item">
                                        <a href="index.html" class="nav-link ">Cloud Server Gold</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="/client/vps-platium" class="nav-link ">Cloud Server Platinum</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="#hosting" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="hosting"> 
                                <img src="/core/upload/images/hosting.gif" height="25px" alt="" class="me-2">
                                <span>Server Hosting</span>
                            </a>
                            <?php
                                foreach ($ketnoi->get_list("SELECT * FROM `server_hosting` WHERE `status` = 'on' ") as $list_sv ):?>
                            <div class="collapse " id="hosting">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="/client/package-hosting/<?=$list_sv['to_slug'];?>" class="nav-link "><?=$list_sv['name_server'];?></a>
                                    </li>
                                   
                                </ul>
                            </div>
                             <?php endforeach;?>          
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/client/affiliates">
                            <i class="fa-solid fa-link menu-icon"></i>
                                <span>Tiếp Thị Liên Kết</span>
                            </a>
                        </li> -->
                        <li class="menu-label mt-2">
                            <span>Quản Lý Dịch Vụ</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="#donhang" data-bs-toggle="collapse" role="button"
                                > 
                                <img src="/core/upload/images/quanly.gif" height="25px" alt="" class="me-2">
                                <!-- <i class="fa-solid fa-table-columns menu-icon"></i>                                        -->
                                <span> Đơn Hàng</span>
                            </a>
                            <div class="collapse " id="donhang">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="/client/history/hosting" class="nav-link ">Quản lý hosting</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/client/historys/vps" class="nav-link ">Quản lý vps</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <li class="menu-label mt-2">
                            <small class="label-border">
                                <div class="border_left hidden-xs"></div>
                                <div class="border_right"></div>
                            </small>
                            <span>Thanh Toán</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="/client/vps-historys">
                                <img src="/core/upload/images/history.gif" height="25px" alt="" class="me-2">
                                <!-- <i class="fa-solid fa-cart-shopping menu-icon"></i>  -->
                                <span>Đơn Đặt Hàng</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="/client/vps-bills">
                                <!-- <i class="fa-solid fa-file-invoice menu-icon"></i>  -->
                                 <img src="/core/upload/images/invoi.gif" height="25px" alt="" class="me-2">
                                <span>Hóa Đơn</span>
                            </a>
                        </li>
                        <li class="menu-label mt-2">
                            <small class="label-border">
                                <div class="border_left hidden-xs"></div>
                                <div class="border_right"></div>
                            </small>
                            <span>Giao Dịch</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="/client/deposit">
                                <img src="/core/upload/images/bank.gif" height="25px" alt="Nạp Tiền" class="me-2">
                                <!-- <i class="fa-solid fa-money-bill-wave menu-icon"></i>  -->
                                <span> Nạp Tiền</span>
                            </a>
                        </li>
                        
                        <li class="menu-label mt-2">
                            <small class="label-border">
                                <div class="border_left hidden-xs"></div>
                                <div class="border_right"></div>
                            </small>
                            <span>Thêm</span>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="apps-chat.html">
                                <i class="fa-solid fa-book menu-icon"></i> 
                                <span>Tài Liệu API</span>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="/client/blogs">
                                <img src="/core/upload/images/post.gif" height="25px" alt="" class="me-2">
                                <!-- <i class="fa-solid fa-book menu-icon"></i>  -->
                                <span>Bài Viết</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>  
    </div>