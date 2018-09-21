<template>
	<div class="row ml-2">
		<div id="demo-canvas" class="mb-3 bg-light col-8" v-show="defaultView">
		</div>
		<div id="gattbg" v-show="!defaultView" class="col-12">
			<div id="chart_div">
			</div>
		</div>
		<div class="col-3 ml-5" id="description" v-show="defaultView">
			<ul class="list-unstyled">
				<li v-for="item in tasks" id="chl">
					<h4>{{ item.TaskId }}</h4>
					<table class="table table-hover">
						<tbody>
							<tr>
								<td><sup>ES</sup> {{ item.earlyStart }}</td>
								<td><sup>EF</sup> {{ item.earlyFinish }}</td>
							</tr>
							<tr>
								<td><sup>LS</sup> {{ item.lateStart }}</td>
								<td><sup>LF</sup> {{ item.lateFinish }}</td>
							</tr>
							<tr>
								<td>
									<div class="progress">
									  <div class="progress-bar" role="progressbar" v-bind:aria-valuenow="item.Progress"
									  aria-valuemin="0" aria-valuemax="100" v-bind:style="{ width: item.Progress + '%' }">
									    <span class="sr-only">{{ item.Progress }} % Complete</span>
									  </div>
									</div>
								</td>
								<td>
									{{ item.Progress }}%
								</td> 	
							</tr>
						</tbody>
					</table>
				</li>
			</ul>
		</div>
		<nav class="nav">
			<button class="btn btn-danger mr-2 active" @click="compute_network">
				Network Graph
			</button>
			<button class="btn btn-success" @click="gatt_chart">
				Gatt Chart
			</button>
		</nav>
	</div>
</template>
<script>
	export default{
		name:'Graphs',
		components:{
		},
		data(){
			return{
				defaultView:true,
				projectid: this.$route.query.projectId,
				tasks:{},
				projectDuration:0,
				critical_path:[],
				startDate:{},
				
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
					this.startDate = response.data["start_date"];
					this.$nextTick().then(()=>{
						this.compute_network();
					});
				});
			},
			compute_network(){
				var s = new this.$sigma('demo-canvas');
				var data = this.tasks;
				var i = 0;
				for(i in data){
					var tid = data[i].TaskId;
					s.graph.addNode({ id:data[i].TaskId, label:'t'+ tid.toString() , size:10,color:'#ab071f',x:Math.floor((Math.random() * data.length) + data[i].TaskId),y:Math.floor((Math.random() * data.length) + data[i].TaskId)});
				}
				var j,k = 0;
				for(j in data){
					var preceedingTasks = JSON.parse(data[j].PreceedingTasks);
					var taskid = data[j].TaskId;
					for(k in preceedingTasks){
						var taskid2 = preceedingTasks[k];
						var edgeid = taskid2.toString() + taskid.toString();
						edgeid = 'e'+ edgeid;
						var edgelabel = 'time =>' + data[j].Duration;
						s.graph.addEdge({ id:edgeid,source:preceedingTasks[k],target:data[j].TaskId,type:'arrow',label:edgelabel});
					}
				}
				s.settings({
					edgeLabelSize: 'proportional',
					minArrowSize: 10
				});
				s.refresh();
				this.defaultView = true;
			},
			drawChart(){
					var data = new this.$GoogleCharts.api.visualization.DataTable();
					data.addColumn('string', 'Task ID');
					data.addColumn('string', 'Task Name');
					data.addColumn('date', 'Start');
					data.addColumn('date', 'Finish');
					data.addColumn('number', 'Duration');
					data.addColumn('number', 'Percent Complete');
					data.addColumn('string', 'Dependencies');

					var rows = [];
					var row = [];
					var i = 0;
					var projectDate = this.startDate;
					projectDate = Date.parse(projectDate);
					var start = new Date(projectDate);

					var data1 = this.tasks;

					for(i in data1){
						var row = [];
						var identity = 't' + data1[i].TaskId;
						row.push(identity);
						var name = 'Task ' + data1[i].TaskId;
						row.push(name);
						var preceedingTasks = JSON.parse(data1[i].PreceedingTasks);
						var precl = preceedingTasks.length;
						var j,k = 0;
						if(!precl){
							row.push(start);
						}
						else{
							var Durations = [];
							for(j in preceedingTasks){
								var val1 = preceedingTasks[j];
								for(k in data1){
									if(val1 == data1[k].TaskId){
										var duratn = data1[k].Duration;
										break;
									}else{
										continue;
									}
								}
								Durations.push(duratn);
							}
							var yr = parseInt(start.getFullYear());
							var month = parseInt(start.getMonth());
							var day = parseInt(start.getDate());
							day = day + Math.max(...Durations);
							start = new Date(yr,month,day);
							console.log(start);
							row.push(start); 
						}
						//Det End Date
						var year  = parseInt(start.getFullYear());
						var month = parseInt(start.getMonth());
						var day = parseInt(start.getDate());
						day = day + data1[i].Duration;
						row.push(new Date(year,month,day));
						//fill in final row values;
						row.push(data1[i].Duration);
						row.push(data1[i].Progress);
						var j = 0;
						row.push(null);
						data.addRow(row);
					}
					var options = {
						title:'Gantt Chart',
						gantt: {
							criticalPathEnabled: true,
          					trackHeight: 50,
        				},
					    height: 250,
					    width:700,
				  	};
				  	const ganttChart = new this.$GoogleCharts.api.visualization.Gantt(document.getElementById('chart_div'));
						this.$GoogleCharts.api.visualization.events.addListener(ganttChart, 'error', err => {
						    // check error
						    console.log(err.id, err.message);

						    // remove error
							//this.$GoogleCharts.api.visualization.errors.removeError(err.id);

						      //remove all errors
							//google.visualization.errors.removeAll(container);
						});
				  	ganttChart.draw(data,options); 				
			},
			gatt_chart(){
				this.$GoogleCharts.load('visualization',{ 'packages': ['gantt'], callback:this.drawChart });
				this.defaultView = false;
			}	
		}
	}
</script>
<style scoped>
 .row{
 	border-radius:5px;
 }
 .nav{
 	padding-left:14%;
 }
 #demo-canvas{
 	height:300px;
 	border-radius:5px;
 }
 #description{
 	height:300px;
 	overflow-y:scroll;
 	color:white;
 	background-color: rgba(28,28,28,0.78);
 	border-style: solid;
 	border-width: 2px;
 	border-color: rgba(28,28,28,0.34);
 }
 #chl{
 	border-bottom:1px solid silver;
 	margin-bottom: 4px;
 }
 #gattbg{
 	background-color: transparent;
 	max-height:600px;
 	overflow-y: scroll;
 }
 #chart_div{
 	border-radius:5px;
 }
 table{
 	background-color: white;
 	color:black;
 	border-radius: 1px;
 }
</style>