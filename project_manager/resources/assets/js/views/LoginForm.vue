<template>
  <div id="lform" class="col-md-4 col-sm-4">
    <h3>Login</h3>
    <svg width="300" height="25" class="animated fadeIn">
      <line x1="20" y1="0" x2="240" y2="0" style="stroke:rgba(211,211,211,0.6); stroke-width:2"/>
    </svg>
    <form v-on:submit.prevent="checkForm">
      <div class="form-group">
        <label for="uuname">Username:</label>
        <input type="text" class="form-control" v-model="uname" name="username">
      </div>
      <p class="alert alert-danger" v-show="hasError">{{ error_msg }}</p>
      <p class="alert alert-success" v-show="issuccessful">Login Successful.</p>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" v-model="pwd" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <br>
    </form>
    <div class="row" id="chpage">
      <small class="col-md-12"><button @click="showModal" class="btn btn-sm btn_fgt">Forgotten Password?</button></small> 
    </div>
    <svg width="300" height="40" class="animated fadeIn">
      <line x1="0" y1="0" x2="260" y2="0" style="stroke:rgba(211,211,211,0.6); stroke-width:2"/>
    </svg>
    <div class="row" id="lone">
      <div class="btn-group">
        <button type="button" class="btn btn-primary">
          <svg id="circle" height="30" width="30">
            <image x="0" y="0" height="30" width="30"  xlink:href="images/facebook.svg" />
          </svg>
          Facebook
        </button>
        <button type="button" class="btn btn-danger btg">
          <svg id="circle" height="30" width="30">
            <image x="0" y="0" height="30" width="30"  xlink:href="images/google.svg" />
          </svg>
          Google 
        </button>
      </div>
    </div>
     <b-modal ref="myModalRef" hide-footer centered title="Forgot Password">
      <div>
        <form class="form-inline" v-on:submit.prevent="submitEmail">
          <input type="email" class="form-control mb-2" v-model="uemail" placeholder="Registered Email">
          <button class="btn btn-primary mb-2" type="submit">Submit</button>
        </form>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: 'LoginForm',
  data: function (){
    return { 
      uname:'',
      pwd: '',
      hasError: false ,
      uemail: '',
      issuccessful: false,
      error_msg:'Forbidden password or username'
    }
  },
  methods: {
    hrespond(response){
        switch(response.message){
          case 200:
              this.issuccessful = true;
            break;
          case 404:
              this.hasError = true;
              this.error_msg = "Wrong username or password";
            break;
          case 403:
              this.hasError = true;
            break;
        }
        if(this.issuccessful){
          if(response.type == 'Admin'){
            this.$router.push({path:'/dashboard',query:{ user: this.uname, acct_type: response.type }});
          }
          else{
            this.$router.push({ path:'/userdashboard',query:{user:this.uname, acct_type:response.type }});
          }
        }
    },
    checkForm: function(e){
      if(this.uname && this.pwd.length >= 8){
        this.$axios.post('http://pm.glassociates.engineering/login', {
          username: this.uname,
          password: this.pwd
        })
        .then(response=>{
         this.hrespond(response.data);
        })
        .catch(function (error) {
          console.log(error);
        });
      }
      else{
        this.hasError = true;
        e.preventDefault();
        return false;
      }
   e.preventDefault();
    },
    showModal () {
      this.$refs.myModalRef.show()
    },
    hideModal () {
      this.$refs.myModalRef.hide()
    },
    submitEmail(e){
      if(this.uemail){
        axios.post(
          'http://pm.glassociates.engineering/forgot_login',
          { user_email:this.email }
        );
        this.hideModal();
      }
      else{
        return false; 
      }
      e.preventDefault();
    }
  },
  components: {
  }
}
</script>

<style scoped>
#lform {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: black;
}
#lform > form{
  width:90%;
  margin-bottom:20px;
}
button[type="submit"]{
  position:relative;
  right:-80px;
}
#lform label{
  text-align:left;
  position:relative;
  left:-70px;
}
#lform > h3{
  padding-top:25px;
}
#chpage{
  margin-top:30px;
}
#lone{ padding:4px; }
#lone button{ margin:5px; font-size: 12px;}
.btn_fgt{
  color:#428bbe;
  background-color: transparent;
}
.btn_fgt:hover{
  cursor:pointer;
}

</style>
