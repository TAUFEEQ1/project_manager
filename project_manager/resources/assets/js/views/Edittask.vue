<template>
	<div class="p-2">
		<nav class="nav col-md-12 mb-2">
  			<router-link class="task_link btn btn-primary nav-link active mr-3" :to="{ name:'resources', query:{ taskid: taskid }}">Resources</router-link>
  			<router-link class="task_link btn btn-primary nav-link mr-3" :to="{ name:'workers', params:{ taskid:taskid }}">Workers</router-link>
  			<router-link class="task_link btn btn-primary mr-2" :to="{ name:'metadata',params:{ taskid:taskid }}">Meta</router-link>
		</nav>
		<router-view></router-view>
	</div>
</template>
<script>
	export default{
		name:'Edittask',
		components:{
		},
		data(){
			return {
				taskid: '',
			}
		},
		created(){
			this.taskid = this.$route.query.taskid;
		},
		methods:{
		}
	}
</script>
<style scoped>
	nav{
		margin:auto;
	}
	.task_link{
		transform: skewX(-14deg);
	}
</style>