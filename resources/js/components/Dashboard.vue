<template>
  <div class="dashboard" >

    <v-container>
      <v-layout justify-start class="mb-3">
        <h3 style="border-bottom:white solid 3px;">CURRENT TASK</h3>
      </v-layout>

      <v-layout row class="mb-3">
        <!-- <v-tooltip top> -->

          <v-btn small flat color="grey" @click="sortBy('Nama_Proyek')" slot="activator">
            <v-icon small left>folder</v-icon>
            <span class="caption ">By Project Title</span>
          </v-btn>
          <!-- <span>Short Task By Project Tittle</span> -->

        <!-- </v-tooltip> -->

        <!-- <v-tooltip top> -->

          <v-btn small flat color="grey" @click="sortBy('Due')" slot="activator">
            <v-icon small left>date_range</v-icon>
            <span class="caption ">By Due</span>
          </v-btn>
          <!-- <span>Short Task By Due Limit</span> -->
          
        <!-- </v-tooltip> -->
      </v-layout>

     <!-- Current Task -->
      <v-container  class="scroll-y" style=" max-height: 440px;">
        <v-card hover v-ripple class="scroll-y" flat style="background: #424242 !important;" v-for="project in projects" :key="project.title" @click="openTaskDialog(project)">
          <v-layout row wrap :class="`pa-3 project ${project.Status}`">
            <v-flex xs12 md4 >
              <div class="caption grey--text">Project Title</div>
              <div>{{ project.Nama_Proyek }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2>
              <div class="caption grey--text">Task</div>
              <div>{{ project.Task }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2>
              <div class="caption grey--text">Due Date</div>
              <div>{{ project.Due }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2> 
                <div class="caption grey--text">Progress</div>
                <div>
                      <v-progress-linear
                      color="red"
                      height="20"
                      :value="project.Progress"
                      >
                      <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                      <p class="text-xs-center">{{project.Progress}}%</p>
                      </v-progress-linear>
                </div>
            </v-flex>
            <v-flex xs2 sm4 md2>
              <!-- <div class="caption grey--text">Status</div> -->
              <div class="right">
                <v-chip small :class="`${project.Status} white--text my-2 caption`">{{ project.Status }}</v-chip>
              </div>
            </v-flex>
          </v-layout>
          <v-divider></v-divider>
        </v-card>
      </v-container>
     <!-- Current Task -->

     <!-- Task Dialog -->
      <v-layout row justify-center>
        <v-dialog v-model="taskDialog" scrollable persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline">{{editProject.Nama_Proyek}}</span>
                <v-spacer/>
                <span v-if="editProject.User!=''">Last Progress By : {{editProject.User}}</span>
            </v-card-title>
            <v-divider/>
            <span class="ml-4">{{editProject.Divisi}} > {{editProject.Sub_Divisi}} > {{editProject.Task}}</span>

            <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                
                <!-- Task -->
                <v-flex xs12>
                    <v-text-field 
                    v-model="editProject.Sub_Task" 
                    label="Sub Task" readonly
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
                    v-model="editProject.Deskripsi_Sub_Task"
                    
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
                        v-model="editProject.Due"
                        label="Due Date"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker readonly v-model="editProject.Tanggal_Selesai" @input="dateDialog = false"></v-date-picker>
                    </v-menu>
                </v-flex>

                <v-flex xs12 md6>
                    <v-text-field
                        
                        label="Time Remaining"
                        prepend-icon="timer"
                        v-model="editProject.Remaining"
                        readonly
                        
                    ></v-text-field>
                </v-flex>
                <!-- Date & Time Remaininig -->

                <!-- Progress -->
                <v-flex xs12 md4>
                    <v-text-field
                        v-model="editProject.Progress"
                        label="Progress"
                        prepend-icon="timeline"
                        counter='3'
                        type="number"
                        :readonly="editProject.status=='untake'"
                        
                    ></v-text-field>
                </v-flex>
                
                <v-flex xs12 md8>
                    <v-progress-linear
                    color="red"
                    height="20"
                    :value="editProject.Progress"
                    >
                    <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                    <p class="text-xs-center">{{editProject.Progress}}%</p>
                    </v-progress-linear>
                </v-flex>
                <!-- Progress -->

                <!-- Upload File -->
                <v-flex xs6>
                    <v-combobox
                    v-model="namefile"
                
                    counter
                    label="Upload File"
                    chips
                    readonly
                    multiple
                    placeholder="Select your files"
                    prepend-icon="mdi-paperclip"
                    outlined
                    :show-size="1000"
                    :disabled="editProject.Status_Akses=='Locked' || editProject.Status_Akses=='Request Download'"
                    @click="pickFile"
                    >
                    
                    <template v-slot:selection="data">

                        <v-chip
                        
                        color="grey darken-2 accent-4"
                        dark
                        label
                        small
                        close
                        @input="removefile()"
                        >
                        {{ data.item }}
                        </v-chip>

                        <!-- <span
                        v-else-if="index === 2"
                        class="overline grey--text text--darken-3 mx-2"
                        >
                        +{{ file.length - 2 }} File(s)
                        </span> -->

                    </template>
                    </v-combobox>
                    <input
                        type="file"
                        style="display: none"
                        ref="file"
                        accept="*"
                        
                        @change="onFilePicked"
                    >
                </v-flex>
                <!-- Upload File -->

                <!-- Note -->
                <v-flex xs6>
                    <v-textarea
                        outline
                        :disabled="editProject.Status_Akses=='Locked' || editProject.Status_Akses=='Request Download'"
                        label="Note Progress"
                        v-model="editProject.Note"
                        
                    ></v-textarea>
                </v-flex>
                <!-- Note -->

                <!-- Log Progress -->
                <v-flex xs12>
                <v-list subheader>
                    <v-subheader>Log Progress</v-subheader>
                    <v-divider/>
                    <v-list-tile
                        v-for="item in logPengerjaan"
                        :key="item.Id_Log_Pengerjaan"
                        avatar
                    >
                        <v-list-tile-avatar>
                            <v-icon>folder</v-icon>
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                        <!-- <v-list-tile-title v-html="item.date"></v-list-tile-title> -->
                        
                        <v-layout style="width:100%;" row>
                            <v-flex xs6>
                                <div class="caption grey--text">File Name</div>
                                <div>{{item.Berkas.split('/')[3]}}</div>
                            </v-flex>

                            <v-flex xs6>
                                <div class="caption grey--text">Date</div>
                                <div>{{item.Waktu_Selesai.split(' ')[0],}}</div>
                            </v-flex>
                        </v-layout>

                        </v-list-tile-content>

                        <v-list-tile-action>
                            <v-layout row>
                                <v-flex xs6>
                                <v-btn @click="downloadIt(item)" icon ripple v-if="editProject.Status_Akses!='Locked' && item.Berkas!=''">
                                    <v-icon color="grey lighten-1">cloud_download</v-icon>
                                </v-btn>
                                </v-flex>
                                <v-flex xs6>

                                <v-btn @click="noteDialog = !noteDialog; noteText=item.Catatan;noteUser=item.Username"  icon ripple>
                                    <v-icon color="grey lighten-1">message</v-icon>
                                </v-btn>
                                
                                <!-- <v-tooltip right allow-overflow>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon ripple>
                                            <v-icon v-on="on" color="grey lighten-1">message</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Lumayan Sulit</span>
                                </v-tooltip> -->
                                </v-flex>
                            </v-layout>
                        </v-list-tile-action>


                    </v-list-tile>
                </v-list>
                </v-flex>
                <!-- Log Progress -->

                </v-layout>
            </v-container>
            
            <small>*indicates required field</small>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <span> Status : {{editProject.Status_Akses_Pekerjaan}}</span>   
            <v-spacer></v-spacer>

            <v-btn color="blue darken-1" flat @click="taskDialog = false">Close</v-btn>
            <v-btn color="blue darken-1" v-if="editProject.Status_Akses=='Locked' || editProject.Status_Akses=='Request Download'" flat @click="requestDialog = true">REQUEST</v-btn>
            <v-btn color="blue darken-1" v-else flat @click="uploadProgress()">Save</v-btn>

            <!-- <v-btn color="blue darken-1" v-if="editProject.status=='untake'" flat @click="taskDialog = false">Request</v-btn>
            <v-btn color="blue darken-1" v-else flat @click="taskDialog = false">Save</v-btn> -->

            </v-card-actions>
        </v-card>
        </v-dialog>
    </v-layout>
    <!-- Task Dialog -->
    <!-- Note Dialog -->
        <v-dialog
        v-model="noteDialog"
        max-width="290"
        >
        <v-card>
            <v-card-title class="headline">Note by : {{noteUser}}</v-card-title>

            <v-card-text>
                {{noteText}}
            </v-card-text>
        </v-card>
        </v-dialog>
    <!-- Note Dialog -->
    </v-container>
   
  </div>
</template>

<script>
import Controller from '../httpController'
import { mapGetters } from 'vuex'

export default {
  data() {
    return {
      files:[],
      editProject:{
        Id_Akses_Pekerjaan      : '',
        Id_Sub_Item_Pekerjaan   : '',
        Id_Proyek               : '',
        Nama_Proyek             : '',
        Divisi                  : '', 
        Sub_Divisi              : '',                     
        Task                    : '',
        Sub_Task                : '',
        Deskripsi_Sub_Task      : "",
        Due                     : "",
        Progress                : 0,
        Desc                    : "",
        Remaining               : "",
        Status_Progress         : "",
        Tanggal_Selesai         : "",
        Verifikasi              : "",
        Datetime_Request        : "",
        Status_Akses_Pekerjaan  : "",
        Id_Akun                 : 0,
        Username                : "",
        Nama_Pegawai            : "",
        Deskripsi               : "",
        User                    : "",
        Status                  : "",
        Status_Akses            : 'Locked',
        Note                    : '',
      },
      initEditProject:{
        Id_Akses_Pekerjaan      : '',
        Id_Sub_Item_Pekerjaan   : '',
        Id_Proyek               : '',
        Nama_Proyek             : '',
        Divisi                  : '', 
        Sub_Divisi              : '',                     
        Task                    : '',
        Sub_Task                : '',
        Deskripsi_Sub_Task      : "",
        Due                     : "",
        Progress                : 0,
        Desc                    : "",
        Remaining               : "",
        Status_Progress         : "",
        Tanggal_Selesai         : "",
        Verifikasi              : "",
        Datetime_Request        : "",
        Status_Akses_Pekerjaan  : "",
        Id_Akun                 : 0,
        Username                : "",
        Nama_Pegawai            : "",
        Deskripsi               : "",
        User                    : "",
        Status                  : "",
        Status_Akses            : 'Locked',
        Note                    : '',
      },
      projects: [
        // { title: 'Rumah Sakit Arsitektur', task: 'Denah Depan', due: '2019-09-08', status: 'ongoing', progress: '75',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Rumah Makan Arsitektur', task: 'Denah Lt 2',due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Hotel Arsitektur', task: 'Denah Ruang Tamu', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Mall Arsitektur', task: 'Denah Halam', due: '2019-09-08', status: 'overdue', progress: '40',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Rumah Sakit Arsitektur1', task: 'Denah Depan', due: '2019-09-08', status: 'ongoing', progress: '75',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Rumah Makan Arsitektur1', task: 'Denah Lt 2', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Hotel Arsitektur1', task: 'Denah Ruang Tamu', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Mall Arsitektur1', task: 'Denah Halam', due: '2019-09-08', status: 'overdue', progress: '40',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Rumah Sakit Arsitektur2', task: 'Denah Depan', due: '2019-09-08', status: 'ongoing', progress: '75',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Rumah Makan Arsitektur2', task: 'Denah Lt 2', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Hotel Arsitektur2', task: 'Denah Ruang Tamu', due: '2019-09-08', status: 'complete', progress: '100',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},
        // { title: 'Mall Arsitektur2', task: 'Denah Halam', due: '2019-09-08', status: 'overdue', progress: '40',desc:'TEKS Deskripsi singkat mengenai task yang diberikan',remaining:'2 day 3 hour'},

      ],
      
      taskDialog:false,

      noteDialog:false,
      noteText:'',
      noteUser:'',
      
      date: new Date().toISOString().substr(0, 10),
      dateDialog: false,
      files:[],
      namefile:[],
      fileName : '',
      fileUrl: '',
      file:'',
      logPengerjaanData:[],
      logPengerjaan:[],
    }
    
  },
  computed: {
    ...mapGetters({
          Id_Akun: 'LoggedUser/Id_Akun',
      }),
    formTitle () {
      return this.editedIndex === -1 ? 'Add Employee' : 'Edit Employee'
    },
  //   ...mapState({
  //     loading: state => state.User.loading,
  //     error: state => state.User.error,
  //     users: state => state.User.users,
  //   }),
   


  },
  mounted () {
    this.loaddata ()
  },
  methods: {
    async loaddata () {
      try {
          this.projects = (await Controller.getdashboard(this.Id_Akun)).data
          this.logPengerjaanData = (await Controller.getalllogpengerjaan()).data.reverse()
          // console.log(this.logPengerjaanData)
      } catch (err) {
          console.log(err)
      }
    },
    sortBy(prop) {
      this.projects.sort((a,b) => a[prop] < b[prop] ? -1 : 1)
    },

    openTaskDialog(data){
      this.taskDialog=true
      this.editProject=data
      this.logPengerjaan = this.logPengerjaanData.filter(obj=>obj.Id_Sub_Item_Pekerjaan == data.Id_Sub_Item_Pekerjaan && obj.Berkas != '')
      console.log(this.logPengerjaan)
    },

    async uploadProgress(){
        try {
            // let payloadFile={
            //     Berkas  : this.file,
            //     Id_Akun : this.Id_Akun
            // }
            let payloadFile = new FormData();
            payloadFile.append('Berkas',this.file);
            payloadFile.append('Id_Akun',this.Id_Akun);

            const pathfile= (await Controller.uploadfile(payloadFile)).data
            // console.log(pathfile)
            // let Id_Pengerjaan = (this.editProject.Log_Pengerjaan.find(obj => obj.Id_Akun == this.Id_Akun && obj.Berkas == '')).Id_Log_Pengerjaan

            let Id_Pengerjaan = (this.logPengerjaanData.find(obj=>obj.Id_Sub_Item_Pekerjaan == this.editProject.Id_Sub_Item_Pekerjaan && obj.Id_Akun == this.Id_Akun && obj.Berkas == '')).Id_Log_Pengerjaan

            let payload={
                Progress: this.editProject.Progress,
                Catatan : this.editProject.Note,
                Berkas  : pathfile,
            }
            const response= (await Controller.updatelogpengerjaan(payload,Id_Pengerjaan)).data
            if(this.editProject.Progress == 100)
            {
                await this.accessDone()
            }
            else
            {
                await this.duplicateEmptyLog()
            }
            this.removefile()
            // let index = this.editProject.Log_Pengerjaan.findIndex(obj=>obj.Id_Log_Pengerjaan==response.Id_Log_Pengerjaan)
            // Object.assign(this.editProject.Log_Pengerjaan[index], response)
            
            //TANYA VIAN
            // let index = this.logPengerjaanData.findIndex(obj=>obj.Id_Log_Pengerjaan == 1)
            // Object.assign(this.logPengerjaanData[index], response)
            
            this.close()
            this.loaddata()
            // console.log(index)

            // this.requestDialog=false
            this.showAlert('success','Sukses Upload Progress')


        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Upload Progress')

        }
    },
    async accessDone () {
        try {
  
            let payload ={
                Verifikasi:'Done'
            } 
            const response = await Controller.updatejobakses(payload,this.editProject.Id_Akses_Pekerjaan)

            console.log(response)
            await this.getProject()
            // Object.assign(this.employeeData[this.editedIndex], this.editedForm)
            // await this.loaddata()
            // this.close()
            // this.showAlert('success','Sukses Verifikasi')

        } catch (err) {
            // console.log(err)
            // this.showAlert('error','Gagal Verifikasi')
        }
    },
    close () {
        
        setTimeout(() => {
            this.taskDialog=false
            this.addDialog2=false;
            this.editmode=false;
            this.editProject = Object.assign({},this.initEditProject)
            this.templateProject=''
            // this.editedForm = Object.assign({}, this.editedFormDefault)
            // this.editedIndex = -1
        }, 300)
    },
    pickFile () {
        this.$refs.file.click ()
    },

    onFilePicked (e) {
      const files = e.target.files
      if(files[0] !== undefined) {
        this.fileName = files[0].name
        // console.log(this.fileName)
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
          this.namefile.push(this.file.name)
        //   this.namefile[0].size = this.file.size

        //   console.log(this.file)
        //   console.log(files)
        //   console.log("Name : "+this.file.name)
        //   console.log("Size : "+this.file.size)
        //   console.log("Size : "+files.length)
        //   console.log("Text : "+files.text)
        //   console.log("Index : "+files.index)


        //   this.file = files

        })
      } else {
        // console.log("else")
        this.fileName = ''
        this.fileUrl = ''
        

        // this.editedItem.image =''
      }
    },
    removefile(){
        this.namefile=[]
        this.file=''
        this.fileUrl = ''
    },

    async forceFileDownload(response,data){
      const url = window.URL.createObjectURL(new Blob([response.data]))
    //   console.log(url)
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download',data.Berkas.split('/')[3]) //or any other extension
      document.body.appendChild(link)
      link.click()
      await this.accessDone()
      this.editProject.Status_Akses ='Locked'
   

    },

    downloadIt(data) {
    //   console.log('http://localhost:8000/'+data.Berkas)
      this.$http({
        method: 'get',
        url: 'http://localhost:8000/'+data.Berkas,
        responseType: 'arraybuffer'
      })
      .then(response => {
       this.forceFileDownload(response,data)  
      })
      .catch(() => console.log('error occured'))
      
    },
    showAlert (type,alert_message) {

        if(type == 'success'){
          this.alert.icon = 'fas fa-check-circle'
        }
        else if(type == 'error'){
          this.alert.icon = 'fas fa-exclamation-circle'
        }

        this.alert.type = type
        this.alert.message = alert_message
        
        let timer = this.showAlert.timer
        if (timer) {
          clearTimeout(timer)
        }
        this.showAlert.timer = setTimeout(() => {
            this.alert.type = null
            this.alert.icon = null
            this.alert.message = null
        }, 3000)
        
    },
    async duplicateEmptyLog(){
        try {
          let payloadLog ={
              Id_Sub_Item_Pekerjaan : this.editProject.Id_Sub_Item_Pekerjaan,
              Id_Akun : this.Id_Akun
          } 
          const response = await Controller.addlogpengerjaan(payloadLog)

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Mengirim Request')

        }
    },
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
