  <!-- Application vendor css url -->
  <!-- project css file  -->
  <link rel="stylesheet" href="{{ asset('assets/css/luno-style.css') }}">
  <style>
      :root {
          --primary: #4361ee;
          --secondary: #3f37c9;
          --success: #4cc9f0;
          --light: #f8f9fa;
          --dark: #212529;
          --danger: #f72585;
      }

      * {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
          background-color: #f5f7fa;
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
          padding: 20px;
      }

      .upload-container {
          background: white;
          border-radius: 12px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
          width: 100%;
          max-width: 500px;
          padding: 40px;
          transition: all 0.3s ease;
      }

      .upload-header {
          text-align: center;
          margin-bottom: 30px;
      }

      .upload-header h1 {
          color: var(--dark);
          font-size: 24px;
          margin-bottom: 10px;
      }

      .upload-header p {
          color: #6c757d;
          font-size: 14px;
      }

      .upload-area {
          border: 2px dashed #ced4da;
          border-radius: 8px;
          padding: 30px;
          text-align: center;
          margin-bottom: 20px;
          transition: all 0.3s ease;
          position: relative;
          overflow: hidden;
      }

      .upload-area.active {
          border-color: var(--primary);
          background-color: rgba(67, 97, 238, 0.05);
      }

      .upload-area i {
          font-size: 48px;
          color: var(--primary);
          margin-bottom: 15px;
      }

      .upload-area h3 {
          font-size: 18px;
          color: var(--dark);
          margin-bottom: 5px;
      }

      .upload-area p {
          font-size: 14px;
          color: #6c757d;
          margin-bottom: 15px;
      }

      .file-input {
          display: none;
      }

      .browse-btn {
          background-color: var(--primary);
          color: white;
          padding: 10px 20px;
          border-radius: 6px;
          cursor: pointer;
          transition: all 0.3s ease;
          border: none;
          font-weight: 500;
      }

      .browse-btn:hover {
          background-color: var(--secondary);
          transform: translateY(-2px);
      }

      .submit-btn {
          width: 100%;
          background-color: var(--primary);
          color: white;
          padding: 12px;
          border-radius: 6px;
          cursor: pointer;
          transition: all 0.3s ease;
          border: none;
          font-weight: 500;
          font-size: 16px;
      }

      .submit-btn:hover {
          background-color: var(--secondary);
      }

      .submit-btn:disabled {
          background-color: #cccccc;
          cursor: not-allowed;
      }

      .file-info {
          margin-top: 15px;
          padding: 10px;
          background-color: #f8f9fa;
          border-radius: 6px;
          display: none;
      }

      .file-info.active {
          display: block;
          animation: fadeIn 0.3s ease;
      }

      .file-info p {
          display: flex;
          justify-content: space-between;
          margin-bottom: 5px;
      }

      .file-name {
          font-weight: 500;
          color: var(--dark);
      }

      .file-size {
          color: #6c757d;
          font-size: 12px;
      }

      .remove-file {
          color: var(--danger);
          cursor: pointer;
          font-size: 12px;
          margin-left: 10px;
      }

      .alert {
          padding: 15px;
          border-radius: 6px;
          margin-bottom: 20px;
          animation: fadeIn 0.3s ease;
      }

      .alert-success {
          background-color: rgba(76, 201, 240, 0.2);
          color: #0c5460;
          border-left: 4px solid var(--success);
      }

      .alert-danger {
          background-color: rgba(247, 37, 133, 0.1);
          color: #721c24;
          border-left: 4px solid var(--danger);
      }

      .alert ul {
          margin-left: 20px;
      }

      @keyframes fadeIn {
          from {
              opacity: 0;
              transform: translateY(-10px);
          }

          to {
              opacity: 1;
              transform: translateY(0);
          }
      }

      @media (max-width: 576px) {
          .upload-container {
              padding: 20px;
          }
      }
  </style>
  <!-- Jquery Core Js -->
  <script src="{{ asset('assets/js/plugins.js') }}"></script>
  </head>


      <div class="sidebar p-2 py-md-3 @@cardClass">
          <div class="container-fluid">
              <div class="title-text d-flex align-items-center mb-4 mt-1">
                  <a href="{{ route('acceuil') }}">
                      <h4 class="sidebar-title mb-0 flex-grow-1"><span class="sm-txt">CIAPOL</span></h4>
                  </a>
              </div>
              <div class="main-menu flex-grow-1">
                  <ul class="menu-list">
                      <li>
                          <a class="m-link
                          @if (in_array(Route::currentRouteName(), ['dashboard'])) active @endif
             "
                              href="{{ route('dashboard') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor"
                                  viewBox="0 0 16 16">
                                  <path fill-rule="evenodd"
                                      d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                  <path class="var(--secondary-color)" fill-rule="evenodd"
                                      d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                              </svg>
                              <span class="ms-2">Dashboard</span>
                          </a>
                      </li>



                      </li>
                  </ul>
                  <ul class="menu-list">
                      <li>
                          <a class="m-link @if (in_array(Route::currentRouteName(), ['entreprises.paiements.index'])) active @endif"
                              href="{{ route('entreprises.paiements.index') }}">
                              <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                  viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">

                                  <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                      stroke="none">
                                      <path d="M866 4675 c-49 -17 -93 -59 -117 -110 -18 -38 -19 -83 -19 -845 0
                                        -762 1 -807 19 -846 25 -55 83 -101 145 -114 35 -8 271 -10 735 -8 l685 3 6
                                        25 c4 14 10 46 13 73 l7 47 -714 0 c-636 0 -716 2 -730 16 -14 14 -16 72 -16
                                        495 l0 479 804 0 804 0 5 33 c3 17 16 96 28 175 21 141 22 142 48 142 14 0
                                        212 -29 439 -63 l412 -63 0 205 c0 178 -3 212 -19 246 -23 51 -79 101 -128
                                        114 -26 7 -420 11 -1203 11 -963 -1 -1172 -3 -1204 -15z m2385 -145 c16 -9 19
                                        -22 19 -95 l0 -85 -1195 0 -1195 0 0 79 c0 59 4 84 16 95 14 14 134 16 1175
                                        16 781 0 1167 -3 1180 -10z" />
                                      <path d="M2557 3364 c-59 -394 -106 -718 -104 -720 7 -7 2441 -373 2446 -368
                                        6 6 221 1427 217 1431 -1 2 -119 21 -262 43 -318 48 -2183 330 -2187 330 -1 0
                                        -51 -322 -110 -716z m1298 291 c424 -64 782 -118 798 -121 23 -5 27 -10 27
                                        -41 0 -19 8 -51 17 -70 18 -39 85 -93 116 -93 16 0 18 -5 13 -32 -7 -38 -86
                                        -564 -86 -573 0 -3 -18 -5 -40 -5 -69 0 -125 -41 -155 -113 -13 -31 -19 -36
                                        -38 -32 -12 2 -368 57 -792 120 -423 64 -782 118 -797 121 -23 5 -28 11 -28
                                        37 0 69 -78 167 -132 167 -10 0 -18 4 -18 10 0 10 75 508 85 568 5 29 9 32 41
                                        32 20 0 52 8 71 17 39 18 93 85 93 115 0 16 5 19 28 14 15 -3 374 -58 797
                                        -121z" />
                                      <path d="M3777 3522 c-10 -10 -17 -26 -17 -35 0 -9 -17 -28 -37 -41 -98 -62
                                        -127 -147 -84 -241 23 -51 47 -72 107 -94 52 -20 68 -47 40 -70 -22 -18 -45
                                        -6 -58 29 -18 52 -66 65 -112 29 -19 -15 -26 -30 -26 -53 0 -33 39 -103 66
                                        -119 8 -4 14 -24 14 -42 0 -44 29 -75 70 -75 34 0 70 31 70 60 0 13 11 24 33
                                        34 67 27 114 113 104 188 -10 75 -63 129 -159 161 -22 8 -24 53 -3 61 24 9 43
                                        -3 54 -34 19 -56 88 -66 124 -18 27 36 16 88 -29 137 -23 27 -34 48 -34 70 0
                                        18 -9 40 -20 51 -26 26 -81 26 -103 2z" />
                                      <path d="M3091 3337 c-49 -24 -48 -107 2 -126 23 -9 288 -51 320 -51 28 0 57
                                        37 57 73 0 56 -22 66 -192 93 -182 28 -158 26 -187 11z" />
                                      <path
                                          d="M4122 3173 c-33 -28 -37 -66 -10 -97 21 -25 37 -29 178 -52 172 -27
                                        199 -24 220 26 9 23 9 34 -4 59 -19 35 -16 34 -195 61 -163 24 -164 24 -189 3z" />
                                      <path d="M2085 3710 c-26 -29 -24 -79 4 -102 20 -16 43 -18 187 -18 89 0 165
                                        4 168 8 2 4 8 36 12 70 l7 62 -180 0 c-168 0 -181 -1 -198 -20z" />
                                      <path d="M1090 3385 l0 -275 385 0 385 0 0 275 0 275 -385 0 -385 0 0 -275z" />
                                      <path d="M2096 3438 c-36 -33 -39 -75 -6 -108 18 -18 33 -20 164 -20 164 0
                                        150 -8 162 93 l6 57 -150 0 c-142 0 -152 -1 -176 -22z" />
                                      <path d="M2103 3168 c-27 -13 -43 -55 -32 -84 16 -45 45 -54 170 -54 l117 0 7
                                        43 c3 23 9 57 12 75 l5 32 -128 -1 c-71 0 -139 -5 -151 -11z" />
                                      <path d="M1285 2141 c-157 -39 -615 -195 -615 -209 0 -15 300 -1045 306 -1051
                                        3 -3 46 5 97 17 50 12 102 22 114 22 12 0 199 -65 415 -144 216 -79 431 -156
                                        477 -170 103 -33 212 -43 278 -27 58 15 1850 929 1904 972 47 37 74 103 64
                                        156 -16 92 -87 163 -161 163 -24 -1 -289 -89 -698 -233 l-659 -233 -14 -53
                                        c-50 -199 -229 -312 -427 -271 -85 17 -689 246 -703 267 -31 41 4 113 55 113
                                        12 0 160 -52 329 -116 395 -149 457 -156 546 -67 96 95 85 303 -21 406 -29 28
                                        -139 81 -507 245 -259 115 -491 214 -517 220 -66 17 -181 14 -263 -7z" />
                                      <path d="M218 2077 c-114 -34 -210 -65 -213 -69 -6 -6 442 -1556 454 -1570 6
                                        -7 436 113 448 126 3 3 -97 358 -223 788 -167 570 -233 783 -244 785 -8 0
                                        -108 -26 -222 -60z m107 -132 c14 -13 25 -36 25 -50 0 -29 -40 -75 -65 -75
                                        -20 0 -57 19 -67 34 -4 6 -8 25 -8 41 0 35 7 47 35 63 31 18 54 14 80 -13z" />
                                  </g>
                              </svg>

                              <span class="ms-2">Paiements</span>

                          </a>
                      </li>
                      @if (auth()->user()->hasRole('super-administrateur'))
                          <li>
                              <a class="m-link
                              @if (in_array(Route::currentRouteName(), ['entreprises.index', 'entreprises.taxes.index'])) active @endif
             "
                                  href="{{ route('entreprises.index') }}">

                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                      fill="currentColor" class="bi bi-house-check" viewBox="0 0 16 16">
                                      <path
                                          d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708z" />
                                      <path
                                          d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514" />
                                  </svg>
                                  <span class="ms-2">Entreprise </span>

                              </a>
                          </li>
                          <li>
                              <a class="m-link
                              @if (in_array(Route::currentRouteName(), ['listCheques', 'detail.cheques' ,'cheque.create'])) active @endif
             "
                                  href="{{ route('listCheques') }}">

                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                      fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                                      <path
                                          d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                  </svg>
                                  <span class="ms-2"> Cheques et Virements </span>

                              </a>
                          </li>
                          <li>
                              <a class="m-link
                              @if (in_array(Route::currentRouteName(), ['administrateur.index', 'administrateur.create', 'administrateur.edit'])) active @endif
             "
                                  href="{{ route('administrateur.index') }}">

                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                      fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                                      <path
                                          d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                  </svg>
                                  <span class="ms-2"> Administrateurs </span>

                              </a>
                          </li>
                      @endif
                      <li>
                          <a class="m-link
                          @if (in_array(Route::currentRouteName(), ['profAdmin'])) active @endif
             "
                              href="{{ route('profAdmin') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                  class="bi bi-person-circle" viewBox="0 0 16 16">
                                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                  <path fill-rule="evenodd"
                                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                              </svg>
                              <span class="ms-2">Profil</span>

                          </a>
                      </li>
                      <li>
                          <a class="m-link" href="#"
                              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor"
                                  viewBox="0 0 16 16">
                                  <path d="M7.5 1v7h1V1h-1z" />
                                  <path class="fill-secondary"
                                      d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
                              </svg>
                              <span class="ms-2">Déconnexion</span>
                          </a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <!-- start: body area -->
