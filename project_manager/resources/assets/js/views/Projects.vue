<template>
<div class="row" id="mother">
	<div v-for="item in projectz" class="card mr-4 panel mt-2" style="width:45%">
		<div class="card-body">
			<div class="ptitle card-title">
				<h3 class="text-center">{{ item.Name }}</h3>
			</div>
			<div class="card-block">
				<div class="row">
					<canvas class="col-md-12" v-bind:id="'a'+ item.id.toString()">
						
					</canvas>
					<ul class="list-unstyled list-inline col-md-12">
						<li class="list-inline-item">Task No. : {{ item.TasksNumber }}</li>
						<li class="list-inline-item">Duration : {{ item.Duration }} days.</li>
						<li class="list-inline-item">Begin : {{ item.StartDate }}</li>
						<li class="list-inline-item">End : {{ item.EndDate }}</li>
					</ul>
				</div>
			</div>
			<p class="card-text pfooter">
				<router-link class="btn btn-primary col-md-3" :to="{ path:'/dashboard/projects/details',params:{ projectId: item.id }}">More..</router-link>
				<router-link class="btn btn-success col-md-3" :to="{ path:'/dashboard/projects/modify',params:{ projectId: item.id}}">Modify</router-link>
				<router-link class="btn btn-danger col-md-3" :to="{ path:'/dashboard/projects/archive',params:{ projectId: item.id}}">Archive</router-link>
			</p>
		</div>
	</div>
</div>
</template>
<script>
	export default{
		name:'Projects',
		data(){
			return {
				projectz:{},
			}
		},
		components:{

		},
		mounted(){
			this.$axios.post(
				'http://pm.glassociates.engineering/dashboard_data',
				{ query:'projects'}).then(response =>{
					this.loadProjects(response.data);
					this.$nextTick().then(()=>{
						var i = 0;
						var data = [];
						var data = this.projectz;
					for(i=0;i<data.length; i++){
						this.make_chart(data[i].id,data[i].Status);
					}}

					);
				}

			);
		},
		methods:{
			loadProjects(response){
				this.projectz = response.info;
			},
			make_chart(projectId,status){
				 var data = {
					datasets:[{ data:[status,100-status],backgroundColor:["#5cb85c","#d9534f"],borderColor:["#ffffff","#f9f9f9"],borderWidth:[1,1] }],
					labels:['Complete','Non-complete']
				};
				var project_id = '';
				project_id = 'a' + projectId.toString();
				var ctx	= document.getElementById(project_id);
				var cht = new this.$chart(ctx,{ type: 'doughnut' ,data: data , options:{
					responsive: true,
					title: {
    	    			display: true,
        				position: "top",
 				        text: "% Completion",
        				fontSize: 18,
        				fontColor: "#111"
    				},
    				legend: {
        				display: true,
        				position:"right",
      
    				}
				} });
		},
	}
}
</script>
<style scoped>
	.row[id='mother']{
		padding-left:5%;
		max-height:420px;
		overflow-y: scroll;
	}
	.ptitle{
		background-color:#428bbe;
		color:white;
		border-radius: 4px;
	}
	.card-block{
		margin-bottom: 0px;
	}
	.pfooter{
		margin-top: 0px;
	}
	.panel{
		font-size:14px;
	}
	canvas{
		display:inline-block;
	}
</style>