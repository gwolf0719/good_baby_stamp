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
        <div class="container py-5 text-center" id="stampList">

            <div class="row">
                <h1><?=$card['subject']?></h1>
            </div>
            
            <div class="row" id="">
                <div class="<?=$colClass?>  p-2  stamp" v-for="stamp in stampList">
                        <div class=" bg-white  ratio ratio-1x1 stamp " v-on:click="switchStatus(stamp.cardNum,stamp.status)">
                            <img v-if="stamp.status == 0" src="./assets/img/stamp-0.png" class="rounded-circle  w-100 h-100">
                            <img v-else-if="stamp.status == 1" src="./assets/img/stamp-1.png" class="rounded-circle  w-100 h-100">
                            <img v-else-if="stamp.status == 2" src="./assets/img/stamp-2.png" class="rounded-circle  w-100 h-100">
                        </div>
                </div>
            </div>

            
            <li class="row mt-3">
                <div class="col-12 px-2" v-for="log in stampLogs">
                    <p class=" p-1 mb-1 bg-white  text-dark text-start">{{log.updateDatetime}}  {{log.notice}}</p>    
                </div>
            </div>
        </div>
    </div>


    
    
    <?=view('BabyStamp/template/last_import')?>

    <script>
        

        var stampList = {
            data(){
                return {
                    row : <?=$card['row']?>,
                    col : <?=$card['col']?>,
                    stampList:<?=$card['checkData']?>,
                    col_class:12,
                    stampLogs:<?=json_encode($logs)?>
                }
            },
            methods:{
                switchStatus(cardNum,status){
                    switch(status){
                        case 0:
                            api = "/Api/stampAdd"
                            break;

                        case 1:
                            api = "/Api/stampUse"
                            break;
                        default:
                            break;
                    }

                    axios({
                        method: "post",
                        url: api,
                        data: Qs.stringify({
                            userId:'<?=$user['userId']?>',
                            cardId:'<?=$card['cardId']?>',
                            cardNum:cardNum
                        }),
                        responseType: 'json',
                    })
                    .then(function (response) {
                        console.log(response)
                        location.reload();
                    })
                    
                },
                
                
            }
        }

        var stampListApp = Vue.createApp(stampList).mount("#stampList");
        
    </script>
</body>
</html>