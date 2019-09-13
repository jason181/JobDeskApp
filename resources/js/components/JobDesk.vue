<template>
    <div class="jobdesk">
        <v-container>
            <v-layout justify-start class="mb-3">
                <h3 style="border-bottom:white solid 3px;">LIST PROJECT</h3>
            </v-layout>
            <v-layout row class="mb-3">
            <!-- <v-tooltip top> -->

            <v-btn small flat color="grey" @click="addDialog=true" slot="activator">
                <v-icon small left>create_new_folder</v-icon>
                <span class="caption ">Add Project</span>
            </v-btn>


        </v-layout>
             <v-expansion-panel>
                <v-expansion-panel-content
                v-for="project in projects" 
                :key="project.title"
                expand-icon="mdi-menu-down"
                >
                <template v-slot:header>
                
                    <v-layout row wrap :class="`pa-3`">
                        <v-flex xs12 md4 >
                            <div class="caption grey--text">Project Title</div>
                            <div>{{project.title}}</div>
                        </v-flex>
                        <v-flex xs6 sm4 md2>
                            <div class="caption grey--text">Due Date</div>
                            <div>{{project.due}}</div>
                        </v-flex>     
                    </v-layout>
                    
                </template>

                <v-card class="grey darken-2">
                    <v-container >
                    <v-card hover v-ripple class="scroll-y" v-for="task in project.tasks" :key="task.title" flat style="background: #424242 !important;" @click="openTaskDialog(task)">
                    <v-layout row wrap :class="`pa-3  project ${task.status}`">
                        <v-flex xs12 md4 >
                            <div class="caption grey--text">Division</div>
                            <div>{{task.division}}</div>
                        </v-flex>
                        <v-flex xs6 sm4 md2>
                            <div class="caption grey--text">Task</div>
                            <div>{{task.title}}</div>
                        </v-flex>     
                        <v-flex xs6 sm4 md2>
                            <div class="caption grey--text">Due Date</div>
                            <div>{{task.due}}</div>
                        </v-flex>
                        <v-flex xs6 sm4 md2> 
                            <div class="caption grey--text">Progress</div>
                            <div>
                                <v-progress-linear
                                color="red"
                                height="20"
                                :value="task.progress"
                                >
                                <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                <p class="text-xs-center">{{task.progress}}%</p>
                                </v-progress-linear>
                            </div>
                        </v-flex>
                        <v-flex xs2 sm4 md2>
                            <!-- <div class="caption grey--text">Status</div> -->
                            <div class="right">
                                <v-chip small :class="` white--text my-2 caption ${task.status}`">{{task.status}}</v-chip>
                            </div>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                    </v-card>
                    </v-container>


                    
                </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
              <!-- Task Dialog -->
                <v-layout row justify-center>
                    <v-dialog v-model="taskDialog" persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                        <span class="headline">{{editTask.project}}</span>
                        <v-spacer/>
                            <span v-if="editTask.status!='untake'">Taken By : {{editTask.user}}</span>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                            
                            <!-- Task -->
                            <v-flex xs12>
                                <v-text-field 
                                v-model="editTask.title" 
                                label="Task" readonly
                                prepend-icon="description"
                                ></v-text-field>
                            </v-flex>
                            <!-- Task -->

                            <!-- Description -->
                            <v-flex xs12>
                            
                                <v-textarea
                                outline
                                readonly
                                label="Description"
                                v-model="editTask.desc"
                                
                                ></v-textarea>
                
                            </v-flex>
                            <!-- Description -->

                            <!-- Date & Time Remaininig -->
                            <v-flex xs12 md6>
                                <v-menu
                                v-model="dateDialog"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                                readonly
                                >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                    v-model="editTask.due"
                                    label="Due Date"
                                    prepend-icon="event"
                                    readonly
                                    v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker readonly v-model="editTask.due" @input="dateDialog = false"></v-date-picker>
                                </v-menu>
                            </v-flex>

                            <v-flex xs12 md6>
                                <v-text-field
                                    
                                    label="Time Remaining"
                                    prepend-icon="timer"
                                    v-model="editTask.remaining"
                                    readonly
                                    
                                ></v-text-field>
                            </v-flex>
                            <!-- Date & Time Remaininig -->

                            <!-- Progress -->
                            <v-flex xs12 md4>
                                <v-text-field
                                    v-model="editTask.progress"
                                    label="Progress"
                                    prepend-icon="timeline"
                                    counter='3'
                                    type="number"
                                    :readonly="editTask.status=='untake'"
                                    
                                ></v-text-field>
                            </v-flex>
                            
                            <v-flex xs12 md8>
                                <v-progress-linear
                                color="red"
                                height="20"
                                :value="editTask.progress"
                                >
                                <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                <p class="text-xs-center">{{editTask.progress}}%</p>
                                </v-progress-linear>
                            </v-flex>
                            <!-- Progress -->

                            <!-- Upload File -->
                            <v-flex xs12>
                                <v-text-field
                                v-model="file"
                            
                                counter
                                label="Upload File"
                                multiple
                                placeholder="Select your files"
                                prepend-icon="mdi-paperclip"
                                outlined
                                :show-size="1000"
                                :disabled="editTask.status=='untake'"
                                @click="pickFile"
                                >
                                <template v-slot:selection="{ index, text }">

                                    <v-chip
                                    v-if="index < 2"
                                    color="deep-purple accent-4"
                                    dark
                                    label
                                    small
                                    >
                                    {{ text }}
                                    </v-chip>

                                    <span
                                    v-else-if="index === 2"
                                    class="overline grey--text text--darken-3 mx-2"
                                    >
                                    +{{ file.length - 2 }} File(s)
                                    </span>

                                </template>
                                </v-text-field>
                                <input
                                    type="file"
                                    style="display: none"
                                    ref="file"
                                    accept="*"
                                    
                                    @change="onFilePicked"
                                >
                            </v-flex>
                            <!-- Upload File -->

                            </v-layout>
                        </v-container>
                       
                        <small>*indicates required field</small>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        
                        <v-btn color="blue darken-1" flat @click="taskDialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" v-if="editTask.status=='untake'" flat @click="taskDialog = false">Take</v-btn>
                        <v-btn color="blue darken-1" v-else flat @click="taskDialog = false">Save</v-btn>

                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-layout>
              <!-- Task Dialog -->

              <!-- Add Dialog  -->
                <v-layout row justify-center>
                    <v-dialog v-model="addDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar>
                            <v-btn icon dark @click="closeAddDialog();">
                                <v-icon>close</v-icon>
                            </v-btn>
                            <v-toolbar-title class="white--text">Add Project</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn dark flat @click="addProject(editProject);closeAddDialog();">Save</v-btn>
                            </v-toolbar-items>
                        </v-toolbar>

                        <v-container fluid>
                            <v-layout row wrap>
                                <v-flex xs12 md4>
                                    <v-card height="100%">
                                        <v-card-title class="justify-center">
                                            <span class="headline">Project Information</span>
                                        </v-card-title>
                                        <v-card-text> 
                                            <v-container>
                                                <v-layout row wrap>
                                                    <v-flex xs12>
                                                        <v-text-field 
                                                        box
                                                        v-model="editProject.title" 
                                                        label="Project Name" 
                                                        prepend-icon="contact_support"
                                                        ></v-text-field>
                                                    </v-flex>          
                                                    <v-flex xs12 md6 class="pr-2">
                                                        <v-text-field 
                                                        box
                                                        v-model="editProject.value" 
                                                        label="Value" 
                                                        prepend-icon="contact_support"
                                                        ></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs12 md6>
                                                        <v-text-field 
                                                        box
                                                        v-model="editProject.target_outcome" 
                                                        label="Target Outcome" 
                                                        prepend-icon="contact_support"
                                                        ></v-text-field>
                                                    </v-flex>

                                                    <v-flex xs12 md6 class="pr-2">
                                                        <v-menu
                                                        v-model="startDate"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        full-width
                                                        min-width="290px"
                                                        
                                                        >
                                                        <template v-slot:activator="{ on }">
                                                            <v-text-field
                                                            v-model="editProject.start"
                                                            label="Start Date"
                                                            prepend-icon="event"
                                                            box
                                                            v-on="on"
                                                            readonly
                                                            ></v-text-field>
                                                        </template>
                                                        <v-date-picker  v-model="editProject.start" @input="startDate = false"></v-date-picker>
                                                        </v-menu>
                                                    </v-flex>
                                                    <v-flex xs12 md6>
                                                        <v-menu
                                                        v-model="finishDate"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        full-width
                                                        min-width="290px"
                                                        
                                                        >
                                                        <template v-slot:activator="{ on }">
                                                            <v-text-field
                                                            v-model="editProject.due"
                                                            label="Finish Date"
                                                            prepend-icon="event"
                                                            box
                                                            v-on="on"
                                                            readonly
                                                            ></v-text-field>
                                                        </template>
                                                        <v-date-picker  v-model="editProject.due" @input="finishDate = false"></v-date-picker>
                                                        </v-menu>
                                                    </v-flex>
                                                    <v-flex xs12>
                                                        <v-textarea    
                                                        box                                     
                                                        label="Note"
                                                        v-model="editProject.note"
                                                        prepend-icon="contact_support"

                                                        ></v-textarea>
                                                    </v-flex>                                                    
                                                </v-layout>
                                               
                                            </v-container>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>    
                                <v-flex xs12 md4>
                                    <v-card  height="100%">
                                        <v-card-title class="justify-center">
                                            <span class="headline">Client Information</span>
                                        </v-card-title>
                                        <v-card-text> 
                                             <v-container>
                                                <v-layout row wrap>
                                                    <v-flex xs8 >
                                                        <v-text-field 
                                                        box
                                                        v-model="editProject.client_name" 
                                                        label="Client Name" 
                                                        prepend-icon="contact_support"
                                                        ></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs12>
                                                        <v-textarea    
                                                        box                                     
                                                        label="Client Address"
                                                        v-model="editProject.client_address"
                                                        prepend-icon="contact_support"
                                                        ></v-textarea>
                                                    </v-flex>
                                                </v-layout>
                                            </v-container>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>   
                                <v-flex xs12 md4>
                                    <v-card  height="100%">
                                        <v-card-title class="justify-center">
                                            <span class="headline">Task Desk</span>
                                        </v-card-title>
                                        <v-card-text> 
                                            <v-container>
                                                <v-layout row wrap>
                                                    <v-flex xs8 >
                                                        <v-text-field 
                                                        box
                                                        v-model="editTask.title" 
                                                        label="Task Name" 
                                                        prepend-icon="contact_support"
                                                        ></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs12 md6 class="pr-2">
                                                        <v-select
                                                        :items="division"
                                                        v-model ="editTask.division"
                                                        box
                                                        label="Division"
                                                        prepend-icon="contact_support"
                                                        ></v-select>
                                                    </v-flex>
                                                    <v-flex xs12 md6 >
                                                        <v-menu
                                                        v-model="dateDialog"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        full-width
                                                        min-width="290px"
                                                        
                                                        >
                                                        <template v-slot:activator="{ on }">
                                                            <v-text-field
                                                            v-model="editTask.due"
                                                            label="Due Date"
                                                            prepend-icon="event"
                                                            box
                                                            v-on="on"
                                                            readonly
                                                            ></v-text-field>
                                                        </template>
                                                        <v-date-picker  v-model="editTask.due" @input="dateDialog = false"></v-date-picker>
                                                        </v-menu>
                                                    </v-flex>
                                                    <v-flex xs12>
                                                        <v-textarea    
                                                        box                                     
                                                        label="Description"
                                                        v-model="editTask.desc"
                                                        prepend-icon="contact_support"
                                                        ></v-textarea>
                                                    </v-flex>
                                                    <v-flex xs12>
                                                        <v-btn color="green" @click="addTask(editTask)">Add Task</v-btn>
                                                    </v-flex>
                                                </v-layout>
                                            </v-container>
                                        </v-card-text>
                                    </v-card>
                                </v-flex> 
                                <v-divider/>
                                <v-flex xs12>
                                    
                                   <v-card>
                                        <v-card-title class="justify-center">
                                            <span class="headline">Task List</span>
                                         </v-card-title>
                                   </v-card>
                                   <v-card-text v-if="editProject.tasks.length!=0">
                                        <v-card hover v-ripple class="scroll-y"  v-for="task in editProject.tasks" :key="task.title" flat style="background: #424242 !important;" @click="openTaskDialog(task)">
                                        <v-layout row wrap :class="`pa-3  project ${task.status}`">
                                            <v-flex xs12 md4 >
                                                <div class="caption grey--text">Division</div>
                                                <div>{{task.division}}</div>
                                            </v-flex>
                                            <v-flex xs6 sm4 md2>
                                                <div class="caption grey--text">Task</div>
                                                <div>{{task.title}}</div>
                                            </v-flex>     
                                            <v-flex xs6 sm4 md2>
                                                <div class="caption grey--text">Due Date</div>
                                                <div>{{task.due}}</div>
                                            </v-flex>
                                            <v-flex xs6 sm4 md2> 
                                                <div class="caption grey--text">Progress</div>
                                                <div>
                                                    <v-progress-linear
                                                    color="red"
                                                    height="20"
                                                    :value="task.progress"
                                                    >
                                                    <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                                    <p class="text-xs-center">{{task.progress}}%</p>
                                                    </v-progress-linear>
                                                </div>
                                            </v-flex>
                                            <v-flex xs2 sm4 md2>
                                                <!-- <div class="caption grey--text">Status</div> -->
                                                <div class="right">
                                                    <v-chip small :class="` white--text my-2 caption ${task.status}`">{{task.status}}</v-chip>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider></v-divider>
                                        </v-card>
                                    </v-card-text>
                                </v-flex>  
                            </v-layout>

                        </v-container>
                    </v-card>
                    </v-dialog>
                </v-layout>
              <!-- Add Dialog -->

        </v-container>
    </div>
</template>
<script>
export default {
  data() {
    return {
        projects: [

        { 
            tasks:[
                {
                    project:'Rumah Sakit Arsitektur',
                    division: 'Desain', 
                    title: 'Denah Depan', 
                    due: '2019-09-08', 
                    status: 'ongoing', 
                    progress: '75',
                    desc:'TEKS Deskripsi singkat mengenai task yang diberikan',
                    remaining:'2 day 3 hour',
                    user:'Jason'
                },
                {
                    project:'Rumah Sakit Arsitektur',
                    division: 'Desain', 
                    title: 'Denah Ruang Tamu', 
                    due: '2019-09-08', 
                    status: 'untake', 
                    progress: '0',
                    desc:'TEKS Deskripsi singkat mengenai task yang diberikan',
                    remaining:'2 day 3 hour',
                    user:''
                }

            ],
            title: 'Rumah Sakit Arsitektur', 
            due: '2019-09-08', 
        },
        

        ],
        editProject:
        {
            tasks:[],
            title: '', 
            start: '',
            due: '', 
            value:'',
            target_outcome:'',
            note:'',
            client_name:'',
            client_address:'',
        },
        initProject:
        {
            tasks:[],
            title: '', 
            start: '',
            due: '', 
            value:'',
            target_outcome:'',
            note:'',
            client_name:'',
            client_address:'',
        },
        files:[],
        editTask:{
            project:'',
            division:'', 
            title:'',
            due:'',
            status:'untake',
            progress:'0',
            desc:'',
            user:'',
        },
        initEditTask:{
            project:'',
            division:'', 
            title:'',
            due:'',
            status:'untake',
            progress:'0',
            desc:'',
            user:'',
        },
        division: ['Desain', 'Produksi', 'Pendukung', 'Umum'],
        addDialog :false,
        taskDialog:false,
        date: new Date().toISOString().substr(0, 10),
        dateDialog: false,
        startDate:false,
        finishDate:false,
        fileName : '',
        fileUrl: '',
        file:''
    }
  },
   methods: {
    // sortBy(prop) {
    //   this.projects.sort((a,b) => a[prop] < b[prop] ? -1 : 1)
    // },
    addProject(data){
        this.projects.push(data);
    },
    addTask(data){
        console.log(data)
        // Object.assign(this.editProject.tasks[0],data)

        this.editProject.tasks.push(this.editTask);
        // this.editProject.tasks.push(Object.assign({}, data));
    },
    closeAddDialog(){
        this.addDialog=false;
        this.editProject = Object.assign({},this.initProject)
        this.editProject.tasks=[]
        this.editTask = Object.assign({},this.initEditTask)

    },
    openTaskDialog(data){
      this.taskDialog=true
      this.editTask=data
    },

    pickFile () {
        this.$refs.file.click ()
    },

    onFilePicked (e) {
      const files = e.target.files
      if(files[0] !== undefined) {
        this.fileName = files[0].name
        if(this.fileName.lastIndexOf('.') <= 0) {
          // console.log("Masuk return")
          return
        }
        const fr = new FileReader ()
        fr.readAsDataURL(files[0])
        fr.addEventListener('load', () => {
        // console.log(fr.result)
        //  console.log("Masuk FR")


          this.fileUrl = fr.result

          this.file = files[0]
        })
      } else {
        // console.log("else")
        this.fileName = ''
        this.fileUrl = ''
        // this.editedItem.image =''
      }
    },
    // sortByDate(prop){
    //   this.projects.sort((a, b) => new Date(a.due) - new Date(b.due))
    // }
  }
}

</script>

<style>

.project.complete{
  border-left: 4px solid #3cd1c2 !Important;
  border-color:#3cd1c2 !Important;
}
.project.ongoing{
  border-left: 4px solid #ffaa2c !Important;
}
.project.overdue{
  border-left: 4px solid #f83e70 !Important;
}
.project.untake{
  border-left: 4px solid green !Important;
  border-color:green !Important;

}


.v-chip.complete{
  background: #3cd1c2 !Important;
}
.v-chip.ongoing{
  background: #ffaa2c !Important;
}
.v-chip.overdue{
  background: #f83e70 !Important;
}
.v-chip.untake{
  background: green !Important;
}

</style>