<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>UPRESS</title>

    <link href="{{url('landingpage')}}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('landingpage')}}/assets/css/fontawesome.css">
    <link rel="stylesheet" href="{{url('landingpage')}}/assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="{{url('landingpage')}}/assets/css/owl.css">
    <link rel="shortcut icon" href="{{url('assets')}}/logo/upress-logo.png" />

    <script src="{{url('landingpage')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{url('landingpage')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('landingpage')}}/assets/js/custom.js"></script>
    <script src="{{url('landingpage')}}/assets/js/owl.js"></script>
    <script src="{{url('landingpage')}}/assets/js/slick.js"></script>
    <script src="{{url('landingpage')}}/assets/js/isotope.js"></script>
    <script src="{{url('landingpage')}}/assets/js/accordions.js"></script>
</head>

<body>
</body>
    @livewire('components.page-header.page-header')
    {{ $slot }}
    @livewire('components.page-footer.page-footer')
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
    </script>
</html>
