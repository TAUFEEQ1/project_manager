<template>
  <div id="main_container">
    <div class="row">  
      <div class="col-md-8 col-sm-8" id="wall_wrap">
        <div class="mdl-child">
            <h3>Glassociates <small>Project Manager</small></h3>
            <p>For Any account problems please contact +256 751 830 778</p>
        </div>
      </div>
      <LoginForm></LoginForm>
    </div>
  </div>
</template>
<script>

import LoginForm from './LoginForm.vue'
export default {
  name: 'Home',
  components: {
  LoginForm
  }
}
</script>

<style>
#main_container {
  font-family:Roboto;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: white;
  background-color:white;
  box-shadow:  13px 15px 5px rgba(0,0,0,0.6);
  width:75%;
  position:relative;
  left:13%;
}
.mdl-child{
  verticle-align:middle;
  padding-top:30%;
  min-height:500px;
}
#wall_wrap{
  background-image: url(/images/login1.jpg);
  background-size:100%;
  box-shadow:4px 2px 2px white;
}
</style>
