<template>
	<div class="row">
		<table class="table table-hover table-responsive">
			<thead class="bg-light">
				<th class="col">Name</th>
				<th class="col">O.Qty</th>
				<th class="col">C.Qty</th>
				<th class="col">Add / Reduce</th>
				<th class="col">Scaling</th>
			</thead>
			<tbody>
				<tr v-for="(item,index) of resrcs">
					<td class="mr-5">
						{{ item.Name }}
					</td>
					<td class="ml-5">
						{{ item.OriginalQuantity }}
					</td>
					<td>
						{{ item.Quantity }}
					</td>
					<td class="ml-5">
						<form @submit.prevent="chQuantity(item.id, index)" class="form-inline">
							<span>
								<input type="number" class="form-control col-md-4" v-model="tempVal[index]">
								<button type="submit" class="btn btn-primary">&radic;</button>
							</span>
						</form>
					</td>
					<td>
						<form class="form-inline">
							<input type="text" class="form-control" v-model="item.Grouping">
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
				add_rem:[],
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
					this.add_rem = this.add_rem.fill(0,1,response.length-1);
				});
			},
			chQuantity(id,index){
				this.$axios.post('http://pm.glassociates.engineering/resources/edit',{ rsrcId:id,rsrcQty:this.tempVal[index],option:add_rem[index] }).then(response=>{
					this.fetch_data();

				});
			},
			chGrouping(id,index){

			},
		}
	}
</script>
<style scoped>
.first{
	width:10%;
}
table>tbody{
	background-color:white;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>