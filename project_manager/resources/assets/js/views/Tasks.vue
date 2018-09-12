<template>
	<div class="row">
		<table class="table table-hover table-responsive col-md-12 col-sm-12">
			<thead class="bg-light">
				<tr>
					<th scope="col">ProjectID</th>
					<th scope="col">TaskId</th>
					<th scope="col">Workers</th>
					<th scope="col">Duration</th>
					<th scope="col">Times</th>
					<th scope="w-100">Progress</th>
					<th scope="col">Resources</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in Taskz">
					<th scope="row">{{ 'p' + item.ProjectId.toString() }}</th>
					<td><button class="btn btn-link" @click="showTask(item.TaskId)">{{ 't' + item.TaskId }}</button></td>
					<td>
						<b-btn :id="'b'+item.TaskId.toString()" variant="primary">
	          				Workers
	        			</b-btn>
						<b-popover :target="'b'+item.TaskId.toString()" title="Workers" triggers="hover focus">
	        				<ul class="list-unstyled">
	        					<li v-for="worker in item.workers">
	        						{{ worker.WorkerName }}
	        					</li>
	        				</ul>
	      				</b-popover>
					</td>
					<td>{{ item.Duration }}</td>
					<td>
						<b-btn :id="'a'+item.TaskId" variant="primary">
							Times
						</b-btn>
						<b-popover :target="'a'+item.TaskId" title="Times" triggers="hover focus">
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
								</tbody>
							</table>
						</b-popover>
					</td>
					<td class="w-100">
						 <div class="progress">
	  						<div class="progress-bar bg-primary" role="progressbar" v-bind:aria-valuenow="item.Progress" aria-valuemin="0" aria-valuemax="100" v-bind:style="{ width: item.Progress +'%' }">
	    						{{ item.Progress }} %
	  						</div>
						</div> 
					</td>
					<td>
						<button  v-b-modal="'c'+item.TaskId" class="btn btn-primary">
							More..s
						</button>
						<b-modal v-bind:id="'c'+item.TaskId" hide-footer centered title="Resources">
							<canvas v-bind:id="'d'+item.TaskId">
							</canvas>
						</b-modal>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="bg-dark text-white col-md-11" id="bottom_sect">
			<form @submit.prevent="task_range" class="form-inline">
				<div class="form-group">
					<label>Showing from:</label>
					<input type="number" v-model="number1" class="form-control col-md-4">
				</div>
				<div class="form-group">
					<label>To:</label>
					<input type="number" v-model="number2" class="form-control col-md-4">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
				&nbsp; &nbsp; Out of {{ overall }}&nbsp; &nbsp;
				<button class="btn bg-light">Edit Mode</button>
			</form>
		</div>
	</div>
</template>
<script>
	export default{
		name:'Tasks',
		components:{
		},
		data(){
			return{
				number1:1,
				number2:6,
				overall:4,
				Taskz:{},
				tasks:{},
			}
		},
		mounted(){
			this.$axios.get('http://pm.glassociates.engineering/tasks/show').then(response=>{
				this.loadTasks(response.data);
				this.$nextTick().then(()=>{
					let i = {};
					let data = this.tasks;
					for(i in data){
						this.make_chart(data[i]);
					}
				});
			});
		},
		methods:{
			loadTasks(response){
				this.Taskz = response;
				this.tasks = response;
				this.number2 = response.length;
				this.overall = response.length;

			},
			make_chart(i){
				var numberWithCommas = function(x) {
    				return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  				};
				var identity = 'd'+ i.TaskId.toString();
				var data1 = [];
				var data2 = [];
				var data3 = [];
				var rsrc = i.resources;
				var j = {};
				for(j in rsrc){
					data1.push(rsrc[j].Quantity);
					data2.push(rsrc[j].OriginalQuantity-rsrc[j].Quantity);
					data3.push(rsrc[j].Name+ " | " + rsrc[j].Grouping);
				}
				var bar_ctx = document.getElementById(identity);
				var bar_chart = new this.$chart(bar_ctx,{
					type:'bar',
					data:{
						labels: data3,
						datasets:[
							{
								label:'Quantity',
								data: data1,
								backgroundColor: "rgba(55, 160, 225, 0.7)",
								hoverBackgroundColor: "rgba(55, 160, 225, 0.7)",
								hoverBorderWidth: 2,
								hoverBorderColor: 'lightgrey'
							},
							{
								label:'Used Quantity',
								data: data2,
								backgroundColor: "rgba(225, 58, 55, 0.7)",
								hoverBackgroundColor: "rgba(225, 58, 55, 0.7)",
								hoverBorderWidth: 2,
								hoverBorderColor: 'lightgrey'
							},
						]
					},
					options:{
						animation:{
							duration:40,
						},
						tooltips:{
							mode:'label',
							callbacks:{
								label: function(tooltipItem,data){
									return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);		
								}
							}
						},
						scales:{
							xAxes:[{
								stacked:true,
								gridLines: { display: false },
							}],
							yAxes:[{
								stacked:true,
								ticks:{
									callback:function(value){
										return numberWithCommas(value);	
									}
								},

							}]
						}, // Scales.
						legend: { display: true},
					}// options.

				});

			},
			task_range(){
				var nfrom = this.number1;
				var nto = this.number2;
				if(nfrom<= this.overall && nto<=this.overall && nto>0 && nfrom>0){
				this.Taskz = this.tasks.slice(nfrom-1,nto);
				}else{
					alert("Out of range");
				}
			},
			showTask(tid){
				this.$router.push({ path:'edittask',query:{ taskid: tid}});
			}

		}
	}
</script>
<style scoped>
table>tbody{
	background-color: white;
}
table{
	max-height:380px;
	overflow-y: scroll;
}
form .form-group{
	width:29%;
}
#bottom_sect{
	padding-bottom:10px;
	padding-top:10px;
	margin-left:12px;
}
</style>