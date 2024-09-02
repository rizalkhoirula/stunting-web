<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
        <div class="text-center">
                                        <a href="/"><img class="img-fluid" width="150px" height="150px" src="{{ asset('admin/logo/logo-dinkes.png') }}" alt=""></a>
                                    </div>
            <li><a class="ai-icon @if(request()->is('dashboard')) mm-active @endif" href="/dashboard" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>

            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-internet"></i>
                    <span class="nav-text">Data Kriteria</span>
                </a>
                <ul aria-expanded="false">
                    <li @if(request()->is('data-kriteria')) mm-active @endif><a href="/data-kriteria">Kriteria</a></li>
                    <li @if(request()->is('data-subkriteria')) mm-active @endif><a href="/data-subkriteria">Sub Kriteria</a></li>
                </ul>
            </li>
            <li><a href="/data-anak" class="ai-icon @if(request()->is('data-anak')) mm-active @endif" aria-expanded="false">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Anak</span>
                </a>
            </li>
            <li><a href="/data-bantuan" class="ai-icon @if(request()->is('data-bantuan')) mm-active @endif" aria-expanded="false">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Bantuan</span>
                </a>
            </li>
            <li><a href="/data-penghitungan-hasil" class="ai-icon @if(request()->is('data-penghitungan-hasil')) mm-active @endif" aria-expanded="false">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Penghitungan Hasil</span>
                </a>
            </li>
            <li><a href="/data-penghitungan-detail" class="ai-icon @if(request()->is('data-penghitungan-detail')) mm-active @endif" aria-expanded="false">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Penghitungan Detail</span>
                </a>
            </li>
        </ul>
    </div>
</div>
