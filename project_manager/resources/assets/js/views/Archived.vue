<template>
<div>
	<div class="row" id="mother">
		<div v-for="(item,index) in projectz" class="card mr-4 panel mt-2" style="width:45%">
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
					<router-link class="btn btn-primary col-md-3" :to="{ path:'/dashboard/details',query:{ projectId: item.id }}">More..</router-link>
					<button class="btn btn-success col-md-4" @click="Unarchive(item.id,index)">Un-archive</button>
					<button class="btn btn-danger col-md-3" @click="DeleteProject(item.id,index)">Delete</button>
				</p>
			</div>
		</div>
	</div>
	<nav class="navbar col-md-12 mb-2 bg-dark">
		<form class="form-inline col-md-8" v-show="formShown[0]">
			<div class="form-group">
				<label class="mr-1">From:</label>
				<input type="date" class="form-control mr-4">
				<label class="mr-3">To</label>
				<input type="date" class="form-control mr-2">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>	
		</form>
		<form class="form-inline col-6" v-show="formShown[1]">
			<div class="form-group">
				<label>Search</label>
				<input type="text" placeholder="Type in the meta name">
			</div>
		</form>
		<form class="form-inline col-md-8" v-show="formShown[2]">
			<div class="form-group">
				<label class="mr-1">From:</label>
				<input type="number" class="form-control mr-4">
				<label class="mr-3">To</label>
				<input type="number" class="form-control mr-2">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>	
		</form>
		<div class="col-4">
		  <b-dropdown id="ddown1" text="Filter By" class="m-md-2">
		    <b-dropdown-item-button @click="filterByDate('dateRange')">Date Range</b-dropdown-item-button>
		  	<b-dropdown-item-button @click="filterByDate('ascending')">Ascending</b-dropdown-item-button>
		  	<b-dropdown-item-button @click="filterByDate('descending')">Descending</b-dropdown-item-button>
		  	<b-dropdown-divider></b-dropdown-divider>
		    <b-dropdown-item-button @click="filterByNumber">Number Range</b-dropdown-item-button>
		    <b-dropdown-divider></b-dropdown-divider>
		    <b-dropdown-item-button @click="Search">Search</b-dropdown-item-button>
		  </b-dropdown>
		</div>
	</nav>
</div>
</template>
<script>
	export default{
		name:'Archived',
		data(){
			return {
				projectz:{},
				formShown:[true,false,false],

			}
		},
		components:{

		},
		mounted(){
			this.$axios.post(
				'http://pm.glassociates.engineering/dashboard_data',
				{ query:'archived'}).then(response =>{
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
			Unarchive(identity,index){
				this.$axios.post('http://pm.glassociates.engineering/projectz/unarchive',{ projectId: identity }).then(response=>{
					this.$delete(this.projectz,index);
				});
			},
			filterByDate(argument){
				switch(argument){
					case "dateRange":
						break;
				}
			},
			filterByNumber(){

			},
			Search(){

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
		max-height:430px;
		overflow-y: scroll;
		margin-bottom: 10px;
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
		max-height:330px;
	}
	form{
		color:white;
	}
	nav{
		border-radius: 4px;
	}
	canvas{
		display:inline-block;
	}
</style>