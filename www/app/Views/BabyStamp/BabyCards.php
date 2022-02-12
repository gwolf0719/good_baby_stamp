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
            
            <div class="row" id="cardList">
                <div class="col-md-3 col-xs-12  p-2" v-on:click="openForm">
                    <div class="border card  ">
                        <div class="avatar mx-auto bg-white my-5  ratio ratio-1x1 w-50">
                            <img src="./assets/img/plus.png" class="rounded-circle w-100 h-100">
                        </div>
                        <div class="card-body">
                            <h4 class="mb-4">新增集點卡</h4>
                        </div>
                    </div>
                </div>

                <div class=" col-md-3 col-xs-12  p-2 " v-for="crad in cardList">
                    <div class="border card rounded-3 " v-on:click="goToCardInfo(crad.cardId)"> 
                        <div class="avatar mx-auto bg-white my-5  ratio ratio-1x1 w-50">
                            <img src="https://mpng.subpng.com/20180508/etw/kisspng-playing-card-computer-icons-board-game-card-game-card-technology-5af2121953b4d0.1209295515258137853429.jpg" class="rounded-circle  w-100 h-100">
                        </div>
                        <div class="card-body">
                            <h4 class="mb-4">{{crad.subject}}</h4>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addCard" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">新增集點卡</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3 needs-validation" novalidate>
              <div class="">
                <label for="validationCustom01" class="form-label">集點卡標題</label>
                <input type="text" class="form-control"   v-model="subject" required>
                
              </div>
              <div class="">
                <label for="validationCustom02" class="form-label">欄數</label>
                <input type="number" class="form-control"   v-model="col" required>
              </div>
              <div class="">
                <label for="validationCustom02" class="form-label">列數</label>
                <input type="number" class="form-control"   v-model="row" required>
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
        var addCard = new bootstrap.Modal(document.getElementById('addCard'))

        var cardList = {
            data(){
                return {
                    cardList:<?=json_encode($cards)?>
                }
            },
            methods:{
                cards(){
                    axios({
                        method: "post",
                        url: "/Api/cardList/<?=$baby['babyId']?>",
                        responseType: 'json',
                    })
                    .then(function (response) {
                        console.log(response.data.data);
                        cardListApp.cardList = response.data.data;
                    })
                    .catch(function (response) {
                        console.log(response);
                    });
                },
                openForm(){
                    addCard.show();
                },
                goToCardInfo(cardId){
                    location.href = '/BabyStamp/BabyCardInfo/'+cardId
                }
                
            }
        }

        var cardListApp = Vue.createApp(cardList).mount("#cardList");
        
        
        
        const Send = {
            data(){
                return {
                    babyId:'<?=$baby['babyId']?>',
                    subject:'集點卡',
                    row:2,
                    col:6
                }
            },
            methods:{
                sendData(){
                    console.log(this.row)
                    axios({
                        method: "post",
                        url: "/Api/cardAdd",
                        data: Qs.stringify({
                            babyId:this.babyId,
                            subject:this.subject,
                            row:this.row,
                            col:this.col
                        }),
                        responseType: 'json',
                    })
                    .then(function (response) {
                        addCard.hide();
                        cardListApp.cards();
                    })
                    .catch(function (response) {
                        console.log(response);
                    });
                }
                
            }
        }
        Vue.createApp(Send).mount("#addCard");
    </script>
</body>
</html>