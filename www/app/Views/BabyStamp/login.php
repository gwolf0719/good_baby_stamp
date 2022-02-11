<!DOCTYPE html>
<html lang="en">
<head>
    <?=view('BabyStamp/template/head')?>
</head>
<body>
<div class="container" id="container">
    <div class="row">
        <div class="col-md-12 min-vh-100 d-flex flex-column justify-content-center">
            <div class="row">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <a href="<?=$login_link?>">line login</a>
                    <!-- form card login -->
                    <div class="card rounded shadow shadow-sm">
                        <div class="card-header">
                            <h3 class="mb-0">Login</h3>
                        </div>
                        <div class="card-body">
                            <form class="form" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">
                                <div class="form-group">
                                    <label for="uname1">Username</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="uname1" id="uname1" required="" v-model="userId">
                                    <div class="invalid-feedback">Oops, you missed this one.</div>
                                </div>
                                <button type="button"  v-on:click="alertGo" class="btn btn-success btn-lg float-right" id="btnLogin">Login</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
    <?=view('BabyStamp/template/last_import')?>


    <script>
        const Send = {
            data(){
                return {
                    userId:''
                }
            },
            methods:{
                alertGo(){
                    if(this.userId != ""){
                        location.href="./BabyStamp/BabyList/"+this.userId
                    }else{
                        alert('UserName 必須填寫')
                    }
                    
                }
            }
        }
        Vue.createApp(Send).mount("#container");
    </script>
</body>
</html>