<template>
	<div class="row">
		<ul class="list-unstyled list-inline">
			<li class="list-inline-item">
				<router-link class="task_link btn btn-primary" :to="{ name:'resources', query:{ taskid: taskid }}">Resources</router-link>
			</li>
			<li class="list-inline-item">
				<router-link class="task_link btn btn-primary" :to="{ name:'workers', params:{ taskid:taskid }}">Workers</router-link>
			</li>
			<li class="list-inline-item">
				<router-link class="task_link btn btn-primary" :to="{ name:'metadata',params:{ taskid:taskid }}">Meta</router-link>
			</li>
		</ul>
		<div class="row">
			<router-view></router-view>
		</div>
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
	.task_link{
		transform: skewX(-14deg);
	}
	.row{
		margin-left:10px;
	}
	li{
		margin-bottom:100px;
	}
</style>