<template>
  <div>

    <div class="logo"></div>
    <div class="arrow"></div>
    <div class="Chance" v-bind:style="{'transform':'rotate(-'+(step*30)+'deg)'}"></div>

    <div class="fixDown">

      <div v-if="status==1" class="sex">
          <div v-on:click="setSEX('MEN')" v-bind:class="{active:sex=='MEN'}">MEN</div>
          <div v-on:click="setSEX('WOMEN')" v-bind:class="{active:sex=='WOMEN'}">WOMEN</div>
      </div>

     <div v-if="status==1" class="inputMobile">
      <input type="text" v-model="mobile" placeholder="Enter your contact number">
    </div>

    <div v-on:click="runChance" class="bottom">
      <span v-if="!start && status!=1">CHANCE</span>
      <span v-if="start && status!=1">please wait...</span>

      <span v-if="status==1">SUBMIT</span>

    </div>

    </div>

  </div>
</template>

<script>

export default {
    data() {
        return {
            start: false,
            step: 1,
            showForm: false,
            mobile: "",
            status:0,
            sex:""
        }
    },
    methods: {

        setSEX(i){
            this.sex = i;
        },
        runChance() {

            let _this = this;

            if (this.start == false) {
                this.start = true;

                this.send2Server();

            }

        },
        send2Server: function () {

          let TimerInterval = "";
            let _this = this;
            if (this.status==0) {
              TimerInterval = setInterval(function () {
                _this.step++;

              }, 50);
            }

            this.$axios.post('index.php', {
                'mobile': this.mobile,
                'sex': this.sex,
            }, {}).then(resp => {


              clearInterval(TimerInterval);

                console.log(resp.data);

                if (_this.mobile.length>2){
                  _this.mobile = "";
                }

                _this.start = false;
                _this.status = resp.data.status;
                if (resp.data.msg.length>=1) alert(resp.data.msg);

                if (resp.data.status == 1) {
                    _this.step = resp.data.num;
                    ;
                } else if (resp.data.status == -1) {
                    alert("شما قبلا در قرعه کشی شرکت کرده اید");
                }

            }).catch(error => {

            });

        },


    },
    mounted() {


    }
}
</script>

<style>
body, ul, li, p, h1 {
    margin: 0;
    padding: 0;
}

div.form {
    background: rgba(0, 0, 0, 0.4);
    position: fixed;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
}

div.form div.fix {
    background: #fff;
    width: 300px;
    margin: 100px auto;
    left: 0;
    right: 0;
    padding: 10px;
    border-radius: 5px;
}

div.form div.fix label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    font-family: Arial, serif;
    font-size: 13px;
}

div.form div.fix input {
    display: block;
    margin-top: 4px;
    font-weight: bold;
    font-family: Arial, serif;
    font-size: 13px;
    width: 100%;
    border: none;
    background: #ddd;
    padding: 8px;
    border-radius: 4px;
}

div.form div.fix input:focus {
    background: #ccc;
}

div.form div.fix .send {
    display: block;
    margin-top: 8px;
    text-align: center;
    font-weight: bold;
    font-family: Arial, serif;
    cursor: pointer;
    font-size: 13px;
    width: 100%;
    background: #521853;
    color: #fff;
    padding: 13px 8px;
    border-radius: 4px;
}

body {
    background: #521853;
}

div.logo {
    background: url("../static/logo.png");
    background-size: cover;
    width: 230px;
    height: 111px;
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 25px;
}

div.arrow {
    background: url("../static/arrow.png");
    background-size: cover;
    width: 142px;
    height: 130px;
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 145px;
    z-index: 99;
}

div.Chance {
    background: url("../static/Chance.png");
    background-size: cover;
    width: 250px;
    height: 250px;
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 170px;

}
div.fixDown{
    width: 200px;
    height: 46px;
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 440px;
}
div.bottom {
    background: url("../static/bottom.png");
    background-size: cover;
    width: 200px;
    height: 46px;
    margin: 0 auto;
    cursor: pointer;
}

div.inputMobile {
    background-size: cover;
    width: 200px;
    height: 46px;
    margin: 0 auto;
    cursor: pointer;
    top: 440px;
}
div.sex > div.active{
    background:#f5e6bb !important;
    color: #000 !important;
    position: relative;
}
div.sex > div.active:before{
    content: "";
    width: 10px;
    height: 10px;
    background: #f5e6bb;
    position: absolute;
    right: 20px;
    bottom: -5px;
    transform: rotate(45deg);
}

div.inputMobile input {
    width: 100%;
    padding: 10px;
    border: 2px solid #f5e6bb;
    text-align: center;
  border-radius: 100px;
    font-weight: bold;
    color: #000;
}
div.sex{
    width: 200px;
    height: 50px;
    text-align: center;
}
div.sex > div{
    background: #652466;
    color: #b368b4;
    font-weight: bold;
    display:inline-block;
    padding: 5px 0;
    border-radius: 5px;
    width: 90px;
    text-align: center;
    margin: 2px;
}
div.bottom span {
    text-align: center;
    display: block;
    font-weight: bold;
    font-size: 20px;
    line-height: 2.3;
}
</style>
