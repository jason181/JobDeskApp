<template>
  <div class="dashboard" >

    <v-container>
      <v-layout justify-start class="mb-3">
        <h3 style="border-bottom:white solid 3px;">CURRENT TASK</h3>
      </v-layout>

      <v-layout row class="mb-3">
        <!-- <v-tooltip top> -->

          <v-btn small flat color="grey" @click="sortBy('title')" slot="activator">
            <v-icon small left>folder</v-icon>
            <span class="caption ">By Project Tittle</span>
          </v-btn>
          <!-- <span>Short Task By Project Tittle</span> -->

        <!-- </v-tooltip> -->

        <!-- <v-tooltip top> -->

          <v-btn small flat color="grey" @click="sortBy('due')" slot="activator">
            <v-icon small left>date_range</v-icon>
            <span class="caption ">By Due</span>
          </v-btn>
          <!-- <span>Short Task By Due Limit</span> -->
          
        <!-- </v-tooltip> -->
      </v-layout>

     <!-- Current Task -->
      <v-container  class="scroll-y" style=" max-height: 440px;">
        <v-card hover v-ripple class="scroll-y" flat style="background: #424242 !important;" v-for="project in projects" :key="project.title" @click="openTaskDialog(project)">
          <v-layout row wrap :class="`pa-3 project ${project.status}`">
            <v-flex xs12 md4 >
              <div class="caption grey--text">Project Title</div>
              <div>{{ project.title }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2>
              <div class="caption grey--text">Task</div>
              <div>{{ project.task }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2>
              <div class="caption grey--text">Due Date</div>
              <div>{{ project.due }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2> 
                <div class="caption grey--text">Progress</div>
                <div>
                      <v-progress-linear
                      color="red"
                      height="20"
                      :value="project.progress"
                      >
                      <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                      <p class="text-xs-center">{{project.progress}}%</p>
                      </v-progress-linear>
                </div>
            </v-flex>
            <v-flex xs2 sm4 md2>
              <!-- <div class="caption grey--text">Status</div> -->
              <div class="right">
                <v-chip small :class="`${project.status} white--text my-2 caption`">{{ project.status }}</v-chip>
              </div>
            </v-flex>
          </v-layout>
          <v-divider></v-divider>
        </v-card>
      </v-container>
     <!-- Current Task -->

     <!-- Task Dialog -->
      <v-layout row justify-center>
        <v-dialog v-model="taskDialog" persistent max-width="600px">
          <v-card>
            <v-card-title>
              <span class="headline">{{editProject.title}}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  
                 <!-- Task -->
                  <v-flex xs12>
                    <v-text-field 
                    v-model="editProject.task" 
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
                      v-model="editProject.desc"
                       
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
                          v-model="editProject.due"
                          label="Due Date"
                          prepend-icon="event"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker readonly v-model="editProject.due" @input="dateDialog = false"></v-date-picker>
                    </v-menu>
                  </v-flex>

                  <v-flex xs12 md6>
                      <v-text-field
                          
                        label="Time Remaining"
                        prepend-icon="timer"
                        v-model="editProject.remaining"
                        readonly
                          
                      ></v-text-field>
                  </v-flex>
                 <!-- Date & Time Remaininig -->

                 <!-- Progress -->
                  <v-flex xs12 md4>
                      <v-text-field
                          v-model="editProject.progress"
                          label="Progress"
                          prepend-icon="timeline"
                          counter='3'
                          type="number"
                          
                      ></v-text-field>
                  </v-flex>
                 
                  <v-flex xs12 md8>
                     <v-progress-linear
                      color="red"
                      height="20"
                      :value="editProject.progress"
                      >
                      <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                      <p class="text-xs-center">{{editProject.progress}}%</p>
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
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click="taskDialog = false">Close</v-btn>
              <v-btn color="blue darken-1" flat @click="taskDialog = false">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-layout>
     <!-- Task Dialog -->


    </v-container>
   
  </div>
</template>

<script>
export default {
  data() {
    return {
      files:[],
      editProject:{
        title:'',
        task:'',
        due:'',
        status:'',
        progress:'',
        desc:'',
      },
      initEditProject:{
        title:'',
        task:'',
        due:'',
        status:'',
        progress:'',
        desc:'',
      },
      projects: [
        { title: 'Rumah Sakit Arsitektur', task: 'Denah Depan', due: '2019-09-08', status: 'ongoing', progress: '75',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Rumah Makan Arsitektur', task: 'Denah Lt 2',due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Hotel Arsitektur', task: 'Denah Ruang Tamu', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Mall Arsitektur', task: 'Denah Halam', due: '2019-09-08', status: 'overdue', progress: '40',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Rumah Sakit Arsitektur1', task: 'Denah Depan', due: '2019-09-08', status: 'ongoing', progress: '75',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Rumah Makan Arsitektur1', task: 'Denah Lt 2', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Hotel Arsitektur1', task: 'Denah Ruang Tamu', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Mall Arsitektur1', task: 'Denah Halam', due: '2019-09-08', status: 'overdue', progress: '40',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Rumah Sakit Arsitektur2', task: 'Denah Depan', due: '2019-09-08', status: 'ongoing', progress: '75',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Rumah Makan Arsitektur2', task: 'Denah Lt 2', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Hotel Arsitektur2', task: 'Denah Ruang Tamu', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        { title: 'Mall Arsitektur2', task: 'Denah Halam', due: '2019-09-08', status: 'overdue', progress: '40',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},

      ],
      taskDialog:false,
      date: new Date().toISOString().substr(0, 10),
      dateDialog: false,
      fileName : '',
      fileUrl: '',
      file:''
    }
    
  },
  methods: {
    sortBy(prop) {
      this.projects.sort((a,b) => a[prop] < b[prop] ? -1 : 1)
    },

    openTaskDialog(data){
      this.taskDialog=true
      this.editProject=data
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
}
.project.ongoing{
  border-left: 4px solid #ffaa2c !Important;
}
.project.overdue{
  border-left: 4px solid #f83e70 !Important;
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

</style>
