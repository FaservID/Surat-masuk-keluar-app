        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="index.html" class="app-brand-link">
                    <!-- <span class="app-brand-logo demo">
                
              </span> -->
                    <span class="app-brand-text demo menu-text fw-bolder ms-2">SuratApp</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>



            @if(auth()->user()->type === "staff")

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item active">
                    <a href="{{route('staff.home')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Beranda</div>
                    </a>
                </li>

                <!-- Menu Utama -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Menu Utama</span>
                </li>
                <!-- Layouts -->
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-mail-send"></i>
                        <div data-i18n="transaksi surat">Transaksi Surat</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('staff.incomingTransactionIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('staff.outgoingTransactionIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-book"></i>
                        <div data-i18n="buku agenda">Buku Agenda</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('staff.incomingAgendaIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('staff.outgoingAgendaIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- END Menu Utama -->

                <!-- Menu Lainnya -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Menu Lainnya</span>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-images"></i>
                        <div data-i18n="Galeri Surat">Galeri Surat</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('staff.incomingGalleryIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('staff.outgoingGalleryIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="{{route('staff.classificationIndex')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Klasifikasi Surat</div>
                    </a>
                </li>
                <!-- END Menu Lainnya -->
            </ul>

            @endif

            @if(auth()->user()->type === "admin")

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item active">
                    <a href="{{route('admin.home')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Beranda</div>
                    </a>
                </li>

                <!-- Menu Utama -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Menu Utama</span>
                </li>
                <!-- Layouts -->
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-mail-send"></i>
                        <div data-i18n="transaksi surat">Transaksi Surat</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('admin.incomingTransactionIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('admin.outgoingTransactionIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-book"></i>
                        <div data-i18n="buku agenda">Buku Agenda</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('admin.incomingAgendaIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('admin.outgoingAgendaIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- END Menu Utama -->

                <!-- Menu Lainnya -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Menu Lainnya</span>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-images"></i>
                        <div data-i18n="Galeri Surat">Galeri Surat</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('admin.incomingGalleryIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('admin.outgoingGalleryIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="{{route('admin.classificationIndex')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Klasifikasi Surat</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.userIndex')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user-pin"></i>
                        <div data-i18n="Analytics">Kelola Pengguna</div>
                    </a>
                </li>
                <!-- END Menu Lainnya -->
            </ul>

            @endif

            @if(auth()->user()->type === "kabid")
            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item active">
                    <a href="{{route('kabid.home')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Beranda</div>
                    </a>
                </li>

                <!-- Menu Utama -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Menu Utama</span>
                </li>
                <!-- Layouts -->

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-book"></i>
                        <div data-i18n="buku agenda">Buku Agenda</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('kabid.incomingAgendaIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('kabid.outgoingAgendaIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-images"></i>
                        <div data-i18n="Galeri Surat">Galeri Surat</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('kabid.incomingGalleryIndex')}}" class="menu-link">
                                <div data-i18n="Surat Masuk">Surat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('kabid.outgoingGalleryIndex')}}" class="menu-link">
                                <div data-i18n="Surat Keluar">Surat Keluar</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END Menu Utama -->
            </ul>
            @endif
        </aside>
        <!-- / Menu -->
