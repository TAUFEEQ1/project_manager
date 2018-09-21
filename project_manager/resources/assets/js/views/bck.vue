<template>
	<div class="row ml-2">
		<div id="demo-canvas" class="mb-3 col-md-5">
		</div>
		<div class="col-md-5 ml-3" id="description">
			<ul class="list-unstyled">
				<h3 class="text-underline text-center">Description</h3>
				<li v-for="item in tasks" id="chl">
					<h4>{{ item.TaskId }}</h4>
					<ul class="list-unstyled">
						<li>Early Start: {{ item.earlyStart }} | Early Finish: {{ item.lateFinish }}</li>
						<li>Late Start: {{ item.lateStart }} | Late Finish: {{ item.lateFinish }}</li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- <nav class="nav">
			<button class="btn btn-danger mr-2 active">
				Network Graph
			</button>
			<button class="btn btn-success">
				Gatt Chart
			</button>
		</nav> -->
	</div>
</template>
<script>
	export default{
		name:'Graphs',
		components:{
		},
		data(){
			return{
				projectid: this.$route.query.projectId,
				tasks:{},
				projectDuration:0,
				critical_path:[],
			}
		},
		created(){
			this.fetch_data();
		},
		mounted(){
		},
		methods:{
			fetch_data(){
				this.$axios.post('http://pm.glassociates.engineering/taskz/compute',{ projectid: this.projectid }).then(response=>{
					this.tasks = response.data["task_data"];
					this.projectDuration = response.data["duration"];
					this.critical_path = response.data["critical_tasks"];
					this.$nextTick().then(()=>{
						this.compute_network();
					});
				});
			},
			compute_network(){
				var data = this.tasks;
				var G = new this.$jsnx.DiGraph();
				var i = 0;
				var tsks = [];
				for(i in data){
					var node = data[i].TaskId;
					G.addNodesFrom([node],{color:'#d9534f'});
			 		if(data[i].Progress !=0){
			 			if(data[i].Progress == 100){
			 				G.node.get(node).color = 'green';
			 			}else{
			 				G.node.get(node).color = 'orange';
			 			}
			 		}			

				}
				var k = 0;
				var j = 0;
				for(k in data){
					var node = data[k].TaskId;
					var preceedingTasks = JSON.parse(data[k].PreceedingTasks);
					if(!(preceedingTasks.length==0)){
						for(j in preceedingTasks){
							// console.log(preceedingTasks[j]);
							G.addWeightedEdgesFrom([[preceedingTasks[j],data[k].TaskId,6]]);
						}
					}

				}
				var critical = this.critical_path;
				for (var i = 0; i < critical.length; i++) {

					if(i == critical.length -1){
						break;
					}else{
						G.adj.get(critical[i]).get(critical[i+1]).color = 'red';	
					}
				}
				this.$jsnx.draw(G,{
					element:'#demo-canvas',
					withLabels:true,
					weighted:true,
					nodeStyle: {
   						fill: function(d) {
        					return d.data.color;
      					},
      					stroke:'none'
      				},
      				edgeStyle:{
      					fill:function(d){
      						return d.data.color;
      					},
      				},
      				layoutAttr: {
        				charge: -160,
    				},
      				nodeAttr:{
      					r:16,
      				},      				
      				labelStyle: {fill: 'white'},
				});
				//highlighting
			}
		}
	}
</script>
<style scoped>
 .row{
 	border-radius:5px;
 }
 .nav{
 	padding-left:30%;
 }
 #demo-canvas{
 	height:300px;
 	border-radius:5px;
 	background-color: white;
 }
 #description{
 	height:300px;
 	overflow-y: scroll;
 	color:white;
 	background-color: rgba(28,28,28,0.78);
 	border-radius: 5px;
 }
 #chl{
 	border-bottom:1px solid silver;
 	margin-bottom: 4px;
 }
</style>