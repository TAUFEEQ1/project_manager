<template>
	<div class="row">
		<table class="table table-hover table-responsive col-md-12 col-sm-12">
			<thead class="bg-light">
				<th class="col-3">Name</th>
				<th class="col-1">O.Qty</th>
				<th class="col-1">C.Qty</th>
				<th class="col-3">Add / Reduce</th>
				<th class="col-3">Scaling</th>
			</thead>
			<tbody>
				<tr v-for="(item,index) of resrcs">
					<td>
						<input type="checkbox" v-model="checked[index]"/>
						{{ item.Name }}
					</td>
					<td>
						{{ item.OriginalQuantity }}
					</td>
					<td>
						{{ item.Quantity }}
					</td>
					<td>
						<form @submit.prevent="chQuantity(item.id, index)" class="col-md-12">
							<input type="number" class="form-control col-md-6" v-model="tempVal[index]" style="display:inline;">
							<button type="submit" class="btn btn-primary">&radic;</button>
						</form>
					</td>
					<td>
						<form class="form">
								<input type="text" class="form-control col-md-8" v-model="item.Grouping" style="display: inline;">
								<button type="submit" class="btn btn-success">&crarr;</button>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		<b-modal ref="myModalRef">
		</b-modal>
	</div>
</template>
<script>
	export default{
		name:'Resources',
		components:{
		},
		data(){
			return {
				taskid:'',
				resrcs:{},
				tempVal:[],
				checked:[]
			}
		},
		created(){
		},
		mounted(){
			this.taskid = this.$route.query.taskid;
			this.fetch_data();
		},
		methods:{
			fetch_data(){
				this.$axios.post('http://pm.glassociates.engineering/resources/show',
					{ query: this.taskid }
				).then(response=>{
					this.resrcs = response.data;
					this.tempVal = this.tempVal.fill(0,0,response.length-1);
					this.checked = this.add_rem.fill(0,0,response.length-1);
				});
			},
			chQuantity(id,index){
				this.$axios.post('http://pm.glassociates.engineering/resourcez/cqty',{ rsrcId:id,rsrcQty:this.tempVal[index] }).then(response=>{
					var resInfo = response.data;
					var i = 0;
					var data = this.resrcs;
					for(i in data){
						if(data[i].id == id){
							this.resrcs[i].Quantity = resInfo.Quantity;
							this.resrcs[i].OriginalQuantity = resInfo.OriginalQuantity;
							break;
						}
						else{
							continue;
						}
					}

				});
			},
			chGrouping(id,index){

			},
		}
	}
</script>
<style scoped>
/*.row{
	padding:-10px;
	max-height:300px;
	overflow-y:scroll;
	position:fixed;
	bottom:180px;
}*/
	
table>tbody{
	background-color:white;
}
@media screen and (-webkit-min-device-pixel-ratio:0) { 
/* Safari and Chrome */
.col-3 {
 width:16%;
}
.col-1{
	width:6%;
}
}
</style>