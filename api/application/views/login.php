<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?=base_url()?>assets/img/logo/logo.png" rel="icon">
    <title>Login - Análisis Financiero</title>
    <link href="<?=base_url()?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/ruang-admin.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/custom.css" rel="stylesheet">
    <?php
switch (ENVIRONMENT) {
    case 'development':
        ?>
    <script src="//cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <?php
break;
    case 'testing':
    case 'production':
        ?>
    <script src="//cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
    <?php
break;
}
?>
    <script src="//unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    var base_url = '<?=base_url()?>';
    var api_key = '6367a50d-5da3-44a0-ae31-9142090862a4';
    </script>
</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div id="app" class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Iniciar sesión</h1>
                                    </div>
                                    <form v-on:submit.prevent="get_auth()">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="exampleInputEmail"
                                                aria-describedby="emailHelp" placeholder="Digite su correo electrónico"
                                                v-model="email">
                                            <div v-if="validate.email" class="invalid-feedback">
                                                Por favor digite su correo electrónico
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="exampleInputPassword"
                                                placeholder="Contraseña" v-model="password">
                                            <div v-if="validate.password" class="invalid-feedback">
                                                Por favor digite su contraseña
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Ingresar
                                            </button>
                                        </div>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?=base_url()?>assets/js/ruang-admin.min.js"></script>
    <script src="<?=base_url()?>assets/js/app/auth.js"></script>
</body>

</html>