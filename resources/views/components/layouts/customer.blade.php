<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>UPRESS - Customer</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-nfF0pACuL6Df1PEHsuvQa3dxj1qSfWdI6YlY8+NO1L7SdLEqdXt1sGgE4IkuPwKc" crossorigin="anonymous">
        <link rel="stylesheet" href="{{url('landingpage')}}/assets/css/fontawesome.css">
        <link rel="stylesheet" href="{{url('landingpage')}}/assets/css/templatemo-sixteen.css">
        <link rel="stylesheet" href="{{url('landingpage')}}/assets/css/owl.css">
        <link rel="shortcut icon" href="{{url('assets')}}/logo/upress-logo.png" />

        <script src="{{url('assets')}}/vendors/core/core.js"></script>
        <script src="{{url('assets')}}/vendors/flatpickr/flatpickr.min.js"></script>
        <script src="{{url('assets')}}/vendors/apexcharts/apexcharts.min.js"></script>
        <script src="{{url('assets')}}/vendors/feather-icons/feather.min.js"></script>
        <script src="{{url('assets')}}/js/template.js"></script>

        <script src="{{url('/sweetalert2-11.10.1')}}/dist/sweetalert2.all.min.js"></script>
        <link href="{{url('/sweetalert2-11.10.1')}}/dist/sweetalert2.min.css" rel="stylesheet">

        <link href="{{url('landingpage')}}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
        <script src="jquery.min.js" type="text/javascript"></script>
        <script src="jquery.timeago.js" type="text/javascript"></script>
    </head>
    <body>
        @livewire('components.customer-header.customer-header')
        {{ $slot }}
        @livewire('components.customer-footer.customer-footer')
        <style>
            .pagination-container {
                text-align: center;
            }

            .pagination {
                display: inline-block;
                list-style: none;
                padding: 0;
            }

            .pagination > li {
                display: inline-block;
                margin-right: 5px;
            }

            .pagination > li > a,
            .pagination > li > span {
                display: inline-block;
                padding: 5px 10px;
                border: 1px solid #ccc;
                border-radius: 3px;
                text-decoration: none;
                color: #333;
            }

            .pagination > li.active > a,
            .pagination > li.active > span {
                background-color: #007bff;
                color: #fff;
            }

            .pagination > li > a:hover,
            .pagination > li > span:hover {
                background-color: #f0f0f0;
            }

            .pagination > li:first-child > a,
            .pagination > li:last-child > a {
                font-size: 14px; 
            }


        </style>
        <script>
            window.addEventListener('refresh-page', event => {
                window.location.reload(false); 
            })
            window.addEventListener('swal:message', event => {
                Swal.fire({
                    position: event.detail.position,
                    icon: event.detail.icon,
                    title: event.detail.title,
                    text: event.detail.text,
                    showConfirmButton: false,
                    timer: event.detail.timer,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                })
            });

            window.addEventListener('swal:redirect', event => {
                Swal.fire({
                        position: event.detail.position,
                        icon: event.detail.icon,
                        title: event.detail.title,
                        text: event.detail.text,
                        showConfirmButton: false,
                        timer: event.detail.timer,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                        })
                    .then(function() {
                        window.location.href = `${event.detail.link}`
                    });
            });

            window.addEventListener('swal:confirm', event => {
                Swal.fire({
                        position: event.detail.position,
                        icon: event.detail.icon,
                        title: event.detail.title,
                        text: event.detail.text,
                        showConfirmButton: true,
                        })
                    .then(function() {
                        window.location.href = `${event.detail.link}`
                    });
            });

            window.addEventListener('swal:accessrole', event => {
                Swal.fire({
                    position: event.detail.position,
                    icon: event.detail.icon,
                    title: event.detail.title,
                    html: event.detail.html,
                    timer: event.detail.timer
                })
            });

            window.addEventListener('swal:redirect-link', event => {
                Swal.fire({
                        position: event.detail.position,
                        icon: event.detail.icon,
                        title: event.detail.title,
                        html: event.detail.html,
                        timer: event.detail.timer
                    })
                    .then(function() {
                        window.location.href = `${event.detail.link}`
                    });
            });

            window.addEventListener('swal:refresh', event => {
                Swal.fire({
                        position: event.detail.position,
                        icon: event.detail.icon,
                        title: event.detail.title,
                        text: event.detail.text,
                        showConfirmButton: false,
                        timer: event.detail.timer,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    })
                    .then(function() {
                        location.reload();
                    });
            });


            window.addEventListener('swal:confirmation', event => {
                Swal.fire({
                    position: event.detail.position,
                    icon: event.detail.icon,
                    title: event.detail.title,
                    text: event.detail.text,
                    showDenyButton: event.detail.showDenyButton,
                    showCancelButton: event.detail.showCancelButton,
                    confirmButtonText: event.detail.confirmButtonText,
                    denyButtonText: event.detail.denyButtonText
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('confirm');
                    } else if (result.isDenied) {
                        Swal.fire(event.detail.fail_message);
                    }
                })
            });

            window.addEventListener('swal:close-current-tab', event => {
                Swal.fire({
                    position: event.detail.position,
                    icon: event.detail.icon,
                    title: event.detail.title,
                    timer: event.detail.timer
                }).then(function() {
                    window.close();
                });
            });
            window.addEventListener('openModal', function(modal_id){
                $('#'+modal_id.detail).click();
            }); 
            window.addEventListener('closeModal', function(modal_id){
                $('#'+modal_id.detail).click();
            }); 
            window.print_this = function(id) {
                var prtContent = document.getElementById(id);
                var WinPrint = window.open('', '', 'left=0,top=0,width=1500,height=900,toolbar=0,scrollbars=0,status=0');
                
                WinPrint.document.write('<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">');
                
                // To keep styling
                /*var file = WinPrint.document.createElement("link");
                file.setAttribute("rel", "stylesheet");
                file.setAttribute("type", "text/css");
                file.setAttribute("href", 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
                WinPrint.document.head.appendChild(file);*/

                
                WinPrint.document.write(prtContent.innerHTML);
                WinPrint.document.close();
                WinPrint.setTimeout(function(){
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
                }, 1000);
            }
            jQuery(document).ready(function() {
                jQuery("time.timeago").timeago();
            });
        </script>
    </body> 
</html>
