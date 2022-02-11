<!DOCTYPE html>
<html lang="en">
<head>
    <?=view('BabyStamp/template/head')?>

    <style>
        body{
            background-color: #f3c046;
            
        }
        .card{
            border-radius: 5rem!important;
        }
    </style>
</head>
<body>
    <?=view('BabyStamp/template/header')?>
    <div class="main" id="main">
        <div class="container py-5 text-center">
            

            <div class="row" id="babyList">
                

                <div class=" col-md-3 col-xs-12  p-2 " v-for="baby in babylist">
                    <div class="border card rounded-3 " v-on:click="goToCards(baby.babyId)"> 
                        <div class="avatar mx-auto bg-white my-5  ratio ratio-1x1 w-50">
                            <img :src="baby.babyAvatar" class="rounded-circle  w-100 h-100">
                        </div>
                        <div class="card-body">
                            <h4 class="mb-4">{{baby.babyDisplayName}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xs-12  p-2" v-on:click="opForm">
                    <div class="border card  ">
                        <div class="avatar mx-auto bg-white my-5  ratio ratio-1x1 w-50">
                            <img src="./assets/img/plus.png" class="rounded-circle w-100 h-100">
                        </div>
                        <div class="card-body">
                            <h4 class="mb-4">新增成員</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addBbdy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">新增乖寶寶</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3 needs-validation" novalidate>
              <div class="">
                <label for="validationCustom01" class="form-label">寶寶暱稱</label>
                <input type="text" class="form-control"   v-model="babyDisplayName" required>
                
              </div>
              <div class="">
                <label for="validationCustom02" class="form-label">顯示頭像</label>
                <input type="text" class="form-control"   v-model="babyAvatar" required>
                
              </div>
              
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary"  v-on:click="sendData" >Save changes</button>
        </div>
        </div>
    </div>
    </div>
    
    <?=view('BabyStamp/template/last_import')?>

    <script>
        var addBbdy = new bootstrap.Modal(document.getElementById('addBbdy'))

        var babyList = {
            data(){
                return {
                    babylist:<?=json_encode($userBabys)?>
                }
            },
            methods:{
                babys(){
                    axios({
                        method: "post",
                        url: "/Api/babyList/<?=$user['userId']?>",
                        responseType: 'json',
                    })
                    .then(function (response) {
                        babyListApp.babylist = response.data.data;
                    })
                    .catch(function (response) {
                        console.log(response);
                    });
                },
                goToCards(babyId){
                    location.href="./BabyStamp/BabyCards/"+babyId
                }
                ,
                opForm(){
                    addBbdy.show();
                }
            }
        }

        var babyListApp = Vue.createApp(babyList).mount("#babyList");
        
        
        
        const Send = {
            data(){
                return {
                    userId:'<?=$user['userId']?>',
                    babyDisplayName:"Baby"   ,
                    babyAvatar:"https://i.pinimg.com/originals/1c/62/92/1c6292b7d8e5fe3808d0e36a62359b16.png",
                }
            },
            methods:{
                sendData(){
                    
                    axios({
                        method: "post",
                        url: "/Api/babyAdd",
                        data: Qs.stringify({
                            userId:this.userId,
                            babyDisplayName: this.babyDisplayName,
                            babyAvatar: this.babyAvatar
                        }),
                        responseType: 'json',
                    })
                    .then(function (response) {
                        addBbdy.hide();
                        babyListApp.babys();
                    })
                    .catch(function (response) {
                        console.log(response);
                    });
                }
                
            }
        }
        Vue.createApp(Send).mount("#addBbdy");
    </script>
</body>
</html>