<template>
	<div class="p-3">
		<nav class="nav col-md-12 mb-2">
  			<router-link class="task_link btn btn-primary nav-link active mr-3" :to="{ name:'graphs', query:{ projectId: projecId }}">Graphs</router-link>
  			<router-link class="task_link btn btn-primary nav-link mr-3" :to="{ name:'worker', params:{ projectId:projecId }}">Tasks</router-link>
  			<router-link class="task_link btn btn-primary mr-2" :to="{ name:'metadata',params:{ projectId:projecId }}">Meta</router-link>
		</nav>
		<router-view class="col-12"></router-view>
	</div>
</template>
<script>
	export default{
		name:'Details',
		components:{
		},
		data(){
			return {
				projecId:this.$route.query.projectId,
			}
		},
		method:{
		}
	}
</script>
<style scoped>
	.task_link{
		transform: skewX(-14deg);
	}
</style>