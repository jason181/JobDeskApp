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
                expand-icon="mdi-menu-down"
                >
                <template v-slot:header>
                
                    <v-layout row wrap :class="`pa-3`">
                        <v-flex xs12 md4 >
                            <div class="caption grey--text">Project Title</div>
                            <div>Project Title</div>
                        </v-flex>
                        <v-flex xs6 sm4 md2>
                            <div class="caption grey--text">Due Date</div>
                            <div>Project Due</div>
                        </v-flex>     
                    </v-layout>
                    
                </template>
               <!-- Divison -->
                <v-container class="grey darken-2">
                <v-expansion-panel>
                    <v-expansion-panel-content
                    expand-icon="mdi-menu-down"
                    >
                    <template v-slot:header>
                    
                        <v-layout row wrap :class="`pa-3`">
                            <v-flex xs12 md4 >
                                <div class="caption grey--text">Division</div>
                                <div>Divison Name</div>
                            </v-flex>
                            <v-flex xs6 sm4 md2>
                                <div class="caption grey--text">Div Progress</div>
                                <div>Div Progress</div>
                            </v-flex>     
                        </v-layout>
                        
                    </template>

                   <!-- Sub Divison -->
                    <v-container class="grey darken-2">
                    <v-expansion-panel>
                        <v-expansion-panel-content
                        expand-icon="mdi-menu-down"
                        >
                        <template v-slot:header>
                        
                            <v-layout row wrap :class="`pa-3`">
                                <v-flex xs12 md4 >
                                    <div class="caption grey--text">Sub Division</div>
                                    <div>Sub Divison Name</div>
                                </v-flex>
                                <v-flex xs6 sm4 md2>
                                    <div class="caption grey--text">Sub Div Progress</div>
                                    <div>Sub Div Progress</div>
                                </v-flex>     
                            </v-layout>
                            
                        </template>
                       <!-- Task -->
                        <v-container class="grey darken-2">
                        <v-expansion-panel>
                            <v-expansion-panel-content
                            expand-icon="mdi-menu-down"
                            >
                            <template v-slot:header>
                            
                                <v-layout row wrap :class="`pa-3`">
                                    <v-flex xs12 md4 >
                                        <div class="caption grey--text">Task</div>
                                        <div>Task Name</div>
                                    </v-flex>
                                    <v-flex xs6 sm4 md2>
                                        <div class="caption grey--text">Task Progress</div>
                                        <div>Task Progress</div>
                                    </v-flex>     
                                </v-layout>
                                
                            </template>
                           <!--Sub Task -->   
                            <v-card class="grey darken-2">
                                <v-container >
                                <v-card hover v-ripple class="scroll-y" v-for="task in tasks" :key="task.title" flat style="background: #424242 !important;" @click="openTaskDialog(task)">
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
                           <!--Sub Task -->  
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        </v-container>
                       <!-- Task -->
                        
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                    </v-container>
                   <!-- Sub Divison -->

                    </v-expansion-panel-content>
                </v-expansion-panel>
                </v-container>
               <!-- Divison -->
              
                </v-expansion-panel-content>
            </v-expansion-panel>
            
            
        </v-container>
    </div>
</template>
<script>
export default {
  data() {
    return {
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
        projects: [

        { 
            title: 'Rumah Sakit Arsitektur', 
            due: '2019-09-08', 
            div:[
                {
                    name:'Admin',
                    progress:'30',
                    sub_div:[
                        {
                                
                        }
                    ],
                },
                {
                    name:'Design Arsi',
                    progress:'',
                    sub_div:[
                        {
                            name:'Design',
                            progress:'10', 
                            task:[
                                {
                                    name:'Konsep',
                                    progress:'10', 
                                    sub_task:[
                                        {
                                            project:'Rumah Sakit Arsitektur',
                                            division: 'Desain', 
                                            title: 'Konsep Denah Depan', 
                                            due: '2019-09-08', 
                                            status: 'ongoing', 
                                            progress: '75',
                                            desc:'TEKS Deskripsi singkat mengenai task yang diberikan',
                                            remaining:'2 day 3 hour',
                                            user:'Jason'
                                                
                                        }
                                    ],        
                                }
                            ],  
                        },
                        {
                            name:'Produksi',
                            progress:'20',   
                            task:[
                                {
                                        
                                }
                            ],  
                        }
                    ],
                },
            ]
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