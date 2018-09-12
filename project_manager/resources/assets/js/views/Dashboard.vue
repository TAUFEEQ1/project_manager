<template>
	<div class="container-fluid">
		<div class="row">
			<ul class="list-unstyled navbar list-inline col-md-12 bg-light" id="topnav">
				<li class="nav-item list-inline-item mr-5"><h4>Glassociates Project Manager</h4></li>
				<li class="nav-item list-inline-item mr-5"></li>
				<li class="nav-item list-inline-item mr-5">Account-type: {{ account_type }}</li>
				<li class="nav-item list-inline-item mr-5"></li>
				<li class="nav-item list-inline-item mr-2">User-Account: {{ username }} </li>
				<li class="nav-item list-inline-item mr-2">
					<button class="btn btn-danger mt-0">Log Out</button>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-3 card" id="menus">
				<ul class="list-unstyled" id="mainlist">
					<li>
						<h5>Projects</h5>
						<ul class="nav nav-pills">
							<li class="nav-item"><router-link class="nav-link" to="/dashboard/projects">All Projects</router-link></li>
							<li class="nav-item">
								<button @click="showModal('projects')" class="nav-link btn btn-primary btn-sm">Create Project</button>
							</li>
							<li class="nav-item mt-2">
								<router-link class="nav-link" to="/dashboard/projects/archived">Archives</router-link>
							</li>
						</ul>
					</li>
					<li>
						<h5>Tasks</h5>
						<ul class="nav nav-pills">
							<li class="nav-item">
								<router-link class="nav-link" to="/dashboard/tasks">All Tasks</router-link>
							</li>
							<li class="nav-item">
								<button @click="showModal('tasks')" class="nav-link btn btn-primary btn-sm">Create Task</button>
							</li>
						</ul>
					</li>
					<li>
						<h5>Resources</h5>
						<ul class="nav nav-pills">
							<li class="nav-item">
								<router-link class="nav-link" to="/dashboard/resources">All Resources</router-link>
							</li>
						</ul>
					</li>
					<li>
						<h5>Reports</h5>
						<ul class="nav nav-pills">
							<li class="nav-item">
								<router-link class="nav-link" to="/dashboard/reports">All Reports</router-link>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Create Report</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<router-view class="col-md-9"></router-view>
		</div>
		<b-modal ref="myModalRef" hide-footer centered title="Create Projects">
			<form v-on:submit.prevent="checkForm">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
    						<label for="project_name">Project Name</label>
    						<input type="text" v-bind:class="{'form-control':true,'is-invalid':hasError[0]}" placeholder="Not more than 8 letters" v-model="projectName">
    						<small v-show="hasError[0]" class="text-danger">Empty fields are forbidden!</small>
  						</div>
						<div class="form-group">
    						<label for="tasks_no">Number of Tasks</label>
    						<input type="number" v-bind:class="{'form-control':true,'is-invalid':hasError[1]}" placeholder="Number of tasks" v-model="tasksNo">
    						<small v-show="hasError[1]" class="text-danger">Number of Tasks</small>
						</div>
						<div class="form-group">
							<label>Duration in days.</label>
							<input type="number" v-bind:class="{'form-control':true,'is-invalid':hasError[2]}" v-model="duration">
							<small v-show="hasError[2]" class="text-danger">Empty fields are forbidden!</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="begin_date">Begin Date</label>
							<input type="date" class="form-control" placeholder="2018-09-12" v-model="startDate">
							<small v-show="hasError[3]" class="text-danger">Field must not be empty!</small>
						</div>
						<div class="form-group">
							<label for="End_date">End Date</label>
							<input type="date" class="form-control" placeholder="2018-08-12" v-model="endDate">
							<small v-show="hasError[4]" class="text-danger">Field must not be empty!</small>
						</div>
						<div class="form-group">
							<label for="Location">Location</label>
							<input type="text" class="form-control" v-model="location">
							<small v-show="hasError[5]" class="text-danger">Field must not be empty!</small>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>					
			</form>
		</b-modal>
		<b-modal ref="yourModalRef" hide-footer centered title="Create Tasks">
			<form v-on:submit.prevent="checkForm">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
    						<label for="project_name">Project Name</label>
    						<input type="text" v-bind:class="{'form-control':true,'is-invalid':hasError[0]}" placeholder="Not more than 8 letters" v-model="projectName">
    						<small v-show="hasError[0]" class="text-danger">Empty fields are forbidden!</small>
  						</div>
						<div class="form-group">
    						<label for="tasks_no">Number of Tasks</label>
    						<input type="number" v-bind:class="{'form-control':true,'is-invalid':hasError[1]}" placeholder="Number of tasks" v-model="tasksNo">
    						<small v-show="hasError[1]" class="text-danger">Number of Tasks</small>
						</div>
						<div class="form-group">
							<label>Duration in days.</label>
							<input type="number" v-bind:class="{'form-control':true,'is-invalid':hasError[2]}" v-model="duration">
							<small v-show="hasError[2]" class="text-danger">Empty fields are forbidden!</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="begin_date">Begin Date</label>
							<input type="date" class="form-control" placeholder="2018-09-12" v-model="startDate">
							<small v-show="hasError[3]" class="text-danger">Field must not be empty!</small>
						</div>
						<div class="form-group">
							<label for="End_date">End Date</label>
							<input type="date" class="form-control" placeholder="2018-08-12" v-model="endDate">
							<small v-show="hasError[4]" class="text-danger">Field must not be empty!</small>
						</div>
						<div class="form-group">
							<label for="Location">Location</label>
							<input type="text" class="form-control" v-model="location">
							<small v-show="hasError[5]" class="text-danger">Field must not be empty!</small>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>					
			</form>
		</b-modal>
	</div>
</template>
<script>
export default {
  name: 'Dashboard',
  components: {
  },
  data(){
  	return{
  		username: '',
  		account_type:'',
  		hasError: [false,false,false,false,false,false],
  		projectName:'',
  		tasksNo:'',
  		duration:'',
  		startDate:'',
  		endDate:'',
  		location:'',
  	}
  },
  created(){
  	this.username =  this.$route.query.user;
  	this.account_type = this.$route.query.acct_type;
  },
  methods:{
  	Date_correction(date){
  		date_obj = new Date(this.startDate);
  		yr = date_obj.getFullYear();
  		mm = date_obj.getMonth();
  		dd = date_obj.getDate();
  		actualDate = yr + '-'+ mm + '-'+ dd;
  		return actualDate;
  	},
  	checkForm(e){
  		if(this.projectName && this.tasksNo && this.duration && this.startDate && this.endDate){
  			startDate = this.Date_correction(this.startDate);
  			endDate = this.Date_correction(this.endDate);
  			data = { pName:this.projectName,taskNo:this.taskNo, Duration:this.Duration, StartDate:startDate,EndDate:endDate };
  			this.$axios.post('http://pm.glassociates.engineering/projects/create',{ data:data });
  			this.hideModal();
  		}
  		else{
  			var data = new Array();
  			data = [ this.projectName,this.taskNo, this.duration,this.startDate,this.endDate, this.location ];
  			var i = 0;
  			for(i=0;i<data.length;i++){
  				if(!data[i]){
  					this.$set(this.hasError,i,true);
  				}
  				else{
  					continue;
  				}
  			}
  		}
  		e.preventDefault();
  		return false
  	},
  	showModal (theOne) {
 		switch(theOne){
  			case 'projects':
  				this.$refs.myModalRef.show();
  				break;
  			case 'tasks':
  				this.$refs.yourModalRef.show();
  				break;
  		}
    },
    hideModal (theOne) {
 		switch(theOne){
  			case 'projects':
  				this.$refs.myModalRef.hide();
  			case 'tasks':
  				this.$refs.yourModalRef.hide();
  		}
    },
  }
}
</script>
<style>
#menus{
	border-radius:4px;
	box-shadow: 2px 4px 5px #888888;
}
#mainlist>li{
	border-bottom:1px solid silver;
	margin-bottom:20px;
}
#mainlist ul li{
	font-size:14px;
}
#topnav{
	margin-top: -20px;
	margin-bottom: 20px;
	border-radius: 4px;
	padding-top: 20px;
	padding-bottom: 20px;
	display: inline-block;
}
.row{
	width:100%;
}
</style>