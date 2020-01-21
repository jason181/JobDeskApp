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
        <v-card hover v-ripple class="scroll-y" flat style="background: #424242 !important;" v-for="project in tempProjects" :key="project.Id_Sub_Item_Pekerjaan" @click="openTaskDialog(project)">
          <v-layout row wrap :class="`pa-3 project ${project.Status}`">
            <v-flex xs12 md4 >
              <div class="caption grey--text">Project Title</div>
              <div>{{ project.Project }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2>
              <div class="caption grey--text">Task</div>
              <div>{{ project.Task }}</div>
            </v-flex>
            <v-flex xs6 sm4 md2>
              <div class="caption grey--text">Due Date</div>
              <div>{{ project.Tanggal_Selesai }}</div>
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
                    <span class="headline">{{editTask.Projek}}</span>
                    <v-spacer/>
                    <span v-if="editTask.User!=''">Last Progress By : {{editTask.User}}</span>
                </v-card-title>
                <v-divider/>
                <span class="ml-4">{{editTask.Divisi}} > {{editTask.Sub_Divisi}} > {{editTask.Task}}</span>

                <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                    
                    <!-- Task -->
                    <v-flex xs12>
                        <v-text-field 
                        v-model="editTask.Nama" 
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
                        v-model="editTask.Deskripsi"
                        
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
                            v-model="editTask.Tanggal_Selesai"
                            label="Due Date"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker readonly v-model="editTask.Tanggal_Selesai" @input="dateDialog = false"></v-date-picker>
                        </v-menu>
                    </v-flex>

                    <v-flex xs12 md6>
                        <v-text-field
                            
                            label="Time Remaining"
                            prepend-icon="timer"
                            v-model="editTask.Remaining"
                            readonly
                            
                        ></v-text-field>
                    </v-flex>
                    <!-- Date & Time Remaininig -->

                    <!-- Progress -->
                    <v-flex xs12 md4>
                        <v-text-field
                            v-model="editTask.Progress"
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
                        :value="editTask.Progress"
                        >
                        <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                        <p class="text-xs-center">{{editTask.Progress}}%</p>
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
                        :disabled="editTask.Status_Akses=='Locked' || editTask.Status_Akses=='Request Download'"
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
                            :disabled="editTask.Status_Akses=='Locked' || editTask.Status_Akses=='Request Download'"
                            label="Note Progress"
                            v-model="editTask.Note"
                            
                        ></v-textarea>
                    </v-flex>
                    <!-- Note -->

                    <!-- Log Progress -->
                    <v-flex xs12>
                    <v-list subheader>
                        <v-subheader>Log Progress</v-subheader>
                        <v-divider/>
                        <v-list-tile
                            v-for="item in editTask.Log_Pengerjaan.filter(obj=>obj.Berkas!='')"
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
                                    <v-btn @click="downloadIt(item)" icon ripple v-if="editTask.Status_Akses!='Locked' && item.Berkas!=''">
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
                  <span> Status : {{editTask.Status_Akses}}</span>   
                <v-spacer></v-spacer>

                <v-btn color="blue darken-1" flat @click="taskDialog = false">Close</v-btn>
                <v-btn color="blue darken-1" v-if="editTask.Status_Akses=='Locked' || editTask.Status_Akses=='Request Download'" flat @click="requestDialog = true">REQUEST</v-btn>
                
                <v-btn color="blue darken-1" v-else flat @click="uploadProgress()">Save</v-btn>
                <!-- <v-btn color="blue darken-1" v-if="editTask.status=='untake'" flat @click="taskDialog = false">Request</v-btn>
                <v-btn color="blue darken-1" v-else flat @click="taskDialog = false">Save</v-btn> -->

                </v-card-actions>
            </v-card>
            </v-dialog>
        </v-layout>
    <!-- Task Dialog -->

    </v-container>
   
  </div>
</template>

<script>
 import Controller from '../httpController'
 import { mapGetters } from 'vuex'
export default {
  data() {
    return {
       //Base
        alert:{
            type: null,
            message: null,
            icon: null,
        },
        log_pengerjaan:[
            {
                id:'1',
                fileName:'Denah.zip',
                fileUrl:'https://78.media.tumblr.com/tumblr_m39nv7PcCU1r326q7o1_500.png',
                date:'2019-09-09',
                note:'Kurang dikit lagi, Terlalu berat'
            },
             {
                id:'2',
                fileName:'Denah.zip',
                fileUrl:'https://78.media.tumblr.com/tumblr_m39nv7PcCU1r326q7o1_500.png',
                date:'2019-09-08',
                note:''
            }
        ],
        templateProject:'',
        logPengerjaanData:[],
        tempProjects:[],
        projects: [

        { 
            tasks:[
                {
                    project:'Rumah Sakit Arsitektur',
                    division: 'Desain Arsi',
                    sub_division:'Desain', 
                    task:'Konsep',
                    sub_task: 'Denah Depan', 
                    due: '2019-09-08', 
                    status: 'ongoing', 
                    progress: '75',
                    desc:'TEKS Deskripsi singkat mengenai task yang diberikan',
                    remaining:'2 day 3 hour',
                    user:'Jason'
                },
                {
                    project:'Rumah Sakit Arsitektur',
                    division: 'Desain Arsi',
                    sub_division:'QS', 
                    task:'Quality Checking',
                    sub_task: 'Denah Depan', 
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
        namefile:[],
        editTask:{
            Id_Sub_Item_Pekerjaan   : '',
            Id_Item_Pekerjaan       : '',
            Projek                  : '',
            Division                : '', 
            Sub_Division            : '',                     
            Task                    : '',                     
            Nama                    : '',
            Kode                    : '',
            Tanggal_Selesai         : '',
            Persentase              : '',
            User                    : '',
            Remaining               : '',
            Progress                : '0',
            Status                  : 'untake',
            Status_Akses            : 'Locked',
            Log_Pengerjaan          :[],
            Note                    :'',
            Id_Akses                :''
        },
        initEditTask:{
            Id_Sub_Item_Pekerjaan   : '',
            Id_Item_Pekerjaan       : '',
            Projek                  : '',
            Division                : '', 
            Sub_Division            : '',                     
            Task                    : '',                     
            Nama                    : '',
            Kode                    : '',
            Tanggal_Selesai         : '',
            Persentase              : '',
            User                    : '',
            Remaining               : '',
            Progress                : '0',
            Status                  : 'untake',
            Status_Akses            : 'Locked',
            Log_Pengerjaan          :[],
            Note                    :'',
            Id_Akses                :''



        },
        division: ['Desain Arsi', 'Admin'],
        sub_division:[],
        task:[],
        jobAksesData:[],
        reqForm:{
            Status:'',
            Deskripsi:'',
        },
        requestAccess:[
            {Nama: 'Request Access'},
            {Nama: 'Request Download'},
            {Nama: 'Request Overtime'}

        ],
        data_sub_division: [
            {
                division:'Desain Arsi',
                name:'Desain'
            },
            {
                division:'Desain Arsi',
                name:'Produksi'
            },
            {
                division:'Desain Arsi',
                name:'QS'
            }
        ],

        data_task: [
            {
                sub_division:'Desain',
                name:'Konsep'
            },
            {
                sub_division:'Desain',
                name:'D.D'
            },
            {
                division:'Desain',
                name:'Skema'
            }
        ],
        filterDiv:'',
        filterSubDiv:'',
        filterTask:'',

        noteDialog:false,
        noteText:'',
        noteUser:'',
        
        addDialog :false,
        taskDialog:false,
        requestDialog:false,
        date: new Date().toISOString().substr(0, 10),
        dateDialog: false,
        startDate:false,
        finishDate:false,
        fileName : '',
        fileUrl: '',
        file:'',
       //Base

       // Add Dialog 2
        e1: 0,
        addDialog2:false,
        dateDiv1:false,
        dateDiv2:false,
        dateSubDiv1:false,
        dateSubDiv2:false,
        dateTask1:false,
        dateTask2:false,
        dateSubTask1:false,
        dateSubtask2:false,

        editmode:false,


        editProject:
        {
            All_Divisi:[
                {
                    Nama:'Desain Arsi',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Id_Divisi_Role:'1'
                },
                {
                    Nama:'Admin',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Id_Divisi_Role:'1'

                }
            ],
            All_SubDivisi:[
                {
                    Nama:'Desain',
                    Divisi:'Desain Arsi',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                },
                {
                    Nama:'QS',
                    Divisi:'Desain Arsi',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                }
            ],
            All_Task:[
                {
                    Nama:'Konsep',
                    Sub_Divisi:'Desain',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Id_Divisi_Role:'1',
                    Kode:'TSK1',
                    Satuan:'Item'

                },
            ],
            All_SubTask:[
                {
                    Nama:'Denah Depan',
                    Task:'Konsep',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Deskripsi:'A',
                    Kode:'STSK1'
                },
            ],

            Nama: 'Test', 
            Tanggal_Mulai: '2020-10-12',
            Tanggal_Selesai: '2020-10-12', 
            Nilai:'2',
            Target_Outcome:'2020-10-12',
            Catatan:'Cek',
            Pemilik:'A',
            Alamat:'A',
            Kode:'PR2'

        },
        initEditProject:
        {
             All_Divisi:[
                {
                    Nama:'Desain Arsi',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Id_Divisi_Role:'1'
                },
                {
                    Nama:'Admin',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Id_Divisi_Role:'1'

                }
            ],
            All_SubDivisi:[
                {
                    Nama:'Desain',
                    Divisi:'Desain Arsi',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                },
                {
                    Nama:'QS',
                    Divisi:'Desain Arsi',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                }
            ],
            All_Task:[
                {
                    Nama:'Konsep',
                    Sub_Divisi:'Desain',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Id_Divisi_Role:'1',
                    Kode:'TSK1',
                    Satuan:'Item'

                },
            ],
            All_SubTask:[
                {
                    Nama:'Denah Depan',
                    Task:'Konsep',
                    Persentase:'50',
                    Tanggal_Selesai:'2020-10-12',
                    Deskripsi:'A',
                    Kode:'STSK1'
                },
            ],

            Nama: 'Test', 
            Tanggal_Mulai: '2020-10-12',
            Tanggal_Selesai: '2020-10-12', 
            Nilai:'2',
            Target_Outcome:'2020-10-12',
            Catatan:'Cek',
            Pemilik:'A',
            Alamat:'A',
            Kode:'PR2'

        },
    
        div_headers: [
          { text: 'Name',align: 'left',sortable: false,value: 'Nama'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },

        ],
        subdiv_headers: [
          { text: 'Division',align: 'left',sortable: false,value: 'Divisi'},
          { text: 'Name',align: 'left',sortable: false,value: 'Nama'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },
        ],
        task_headers: [
          { text: 'Sub Division',align: 'left',sortable: false,value: 'Sub_Divisi'},
          { text: 'Name',align: 'left',sortable: false,value: 'Nama'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },

        ],
        subtask_headers: [
          { text: 'Task',align: 'left',sortable: false,value: 'Task'},
          { text: 'Name',align: 'left',sortable: false,value: 'Nama'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Description', value: 'Deskripsi',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },

        ],
        divform:{
            Nama:'',
            Persentase:'',
            Tanggal_Selesai:'',
        },
        defaultdivform:{
            Nama:'',
            Persentase:'',
            Tanggal_Selesai:'',
        },
        subdivform:{
            Nama:'',
            Divisi:'',
            Persentase:'',
            Tanggal_Selesai:'',
        },
        defaultsubdivform:{
            Nama:'',
            Divisi:'',
            Persentase:'',
            Tanggal_Selesai:'',
        },
        taskform:{
            Nama:'',
            Sub_Divisi:'',
            Persentase:'',
            Tanggal_Selesai:'',
        },
        defaulttaskform:{
            Nama:'',
            Sub_Divisi:'',
            Persentase:'',
            Tanggal_Selesai:'',
        },
        subtaskform:{
            Nama:'',
            Task:'',
            Persentase:'',
            Tanggal_Selesai:'',
            Deskripsi:''
        },
        defaultsubtaskform:{
            Nama:'',
            Task:'',
            Persentase:'',
            Tanggal_Selesai:'',
            Deskripsi:''

        },
       //Add Dialog 2

       //Data Dummy
        detailDialog:false,
        expandDetail:false,
        detailProject:{
            Nama:'',
            Remaining:'',
            Progress:'',

            All_Divisi:[],
            All_SubDivisi:[],
            All_Task:[],
            All_SubTask:[],
        },
        d_division:[
            {
                id :'2',
                progress:'70',
                name: 'Admin',
            },
            {
                id :'1',
                progress:'70',
                name: 'Desain Arsi',
            }
            
        ],
        d_sub_division:[
            {
                id :'1',
                id_div:'1',
                progress:'70',
                name: 'Desain',
            }
        ],
        d_task:[
            {
                id :'1',
                sub_div:'1',
                progress:'70',
                name: 'Konsep',
            }
        ],
        d_sub_task:[
            {
                id :'1',
                sub_task:'1',
                progress:'70',
                name: 'Denah Depan',
            }
        ],
        search: '',
        headers: [
          {
            text: 'Name',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          { text: 'Division', value: 'division',align: 'center' },
          { text: 'Contribute', value: 'contribute',align: 'center' },
        ],
        d_user:[
            {
                name:'Vian Handika',
                division:'Desain Arsi',
                contribute:'50%',
                task_list:[
                    {
                        name:'Denah Depan',
                        task: 'Konsep',
                        sub_div:'Desain',
                        contribute:'50%'

                    },
                    {
                        name:'Denah Belakang',
                        task: 'Konsep',
                        sub_div:'Desain',
                        contribute:'50%'

                    }
                ]
            }
        ],
       //Data Dummy


    }
  },
   mounted(){
       this.getProject();
   },
   computed:{
       ...mapGetters({
            // id: 'LoggedUser/id',
            Id_Akun: 'LoggedUser/Id_Akun',
            Nama: 'LoggedUser/Name',
            Jabatan: 'LoggedUser/Jabatan',
            Divisi: 'LoggedUser/Divisi',
            
            // username: 'LoggedUser/username',
            // role: 'LoggedUser/role'
        }),
        // filteredTask(data){
        //     if(this.filterDiv!="")
        //     {
        //         return data.filter(obj=>obj.division==this.filterDiv)
        //     }
        //     else 
        //     {
        //         return data.tasks
        //     }
        // }
   },
   methods: {
    // sortBy(prop) {
    //   this.projects.sort((a,b) => a[prop] < b[prop] ? -1 : 1)
    // },
    loadTemplate(){
        // console.log(this.templateProject.toString())
        // console.log(this.tempProjects.find(obj=>obj.Id_Proyek == this.templateProject.toString()))
           this.editProject = Object.assign({},this.tempProjects.find(obj=>obj.Id_Proyek == this.templateProject))
    },
    async addProjectAll(){
        try{
            let response = (await Controller.addproject(this.editProject))
            await this.getProject()
            this.close()
            this.showAlert('success','Sukses Tambah Proyek')

            // for(let item of data){
            //     this.getDataFormat(item)
            // }
            // let data = (await Controller.getallproject()).data
            // this.tempProjects=Object.assign({},data)

            console.log(response)
        }catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Tambah Proyek')

        }
    },
    async updateProjectAll(){
        try{
            let response = (await Controller.updateproject(this.editProject,this.editProject.Id_Proyek))
            console.log(response)
            await this.getProject()
            this.close()
            this.showAlert('success','Sukses Update Proyek')

            // for(let item of data){
            //     this.getDataFormat(item)
            // }
            // let data = (await Controller.getallproject()).data
            // this.tempProjects=Object.assign({},data)

            console.log(response)
        }catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Update Proyek')

        }
    },
    async getProject () {
        try {
            
            let data = (await Controller.getallproject()).data
            this.logPengerjaanData = (await Controller.getalllogpengerjaan()).data
            this.jobAksesData = (await Controller.getalljobakses()).data.filter(obj=>obj.Id_Akun == this.Id_Akun).filter(obj=>obj.Verifikasi == 'Verified')
            
            for(let item of data)
            {
                for(let aksesData of this.jobAksesData)
                {
                    if(item.Id_Proyek == aksesData.Id_Project)
                    {
                        
                        this.getDataFormat(item)
                        break;
                    }
                }
            }

            this.tempProjects=data
            console.log('PRINT')
            console.log(this.tempProjects)
            // this.tempProjects=Object.assign({},data)
            // console.log(this.tempProjects);
            // console.log(JSON.stringify( this.tempProjects, null, 2))


        } catch (err) {
            console.log(err)
        }
    },

    getDataFormat(data){
        let alldivisi =[]
        let allsubdivisi=[]
        let alltask=[]
        let allsubtask=[]

        for(let div of data.Divisi.data){
            let eachdiv ={
                Id_Divisi_Proyek    : div.Id_Divisi_Proyek,
                Id_Divisi_Role      : div.Id_Divisi_Role,
                Id_Proyek           : div.Id_Proyek,
                Nama                : div.Nama,
                Tanggal_Selesai     : div.Tanggal_Selesai.split(' ')[0],
                Persentase          : div.Persentase
            }
            alldivisi.push(eachdiv)
            
            for(let subdiv of div.Sub_Divisi.data){
                let eachsubdiv ={
                    Id_Sub_Divisi_Proyek    :subdiv.Id_Sub_Divisi_Proyek,
                    Id_Divisi_Proyek        : subdiv.Id_Divisi_Proyek,
                    Divisi                  : subdiv.Divisi,
                    Nama                    : subdiv.Nama,
                    Tanggal_Selesai         : subdiv.Tanggal_Selesai.split(' ')[0],
                    Persentase              : subdiv.Persentase
                }
                // console.log(JSON.stringify(eachsubdiv, null, 2))
                allsubdivisi.push(eachsubdiv)

                for(let task of subdiv.Task.data){
                    let eachtask ={
                        Id_Item_Pekerjaan   : task.Id_Item_Pekerjaan,
                        Id_Divisi_Role      : task.Id_Divisi_Role, 
                        Id_Sub_Divisi_Proyek    :task.Id_Sub_Divisi_Proyek,
                        Sub_Divisi          : task.Sub_Divisi,                        
                        Nama                : task.Nama,
                        Kode                : task.Kode,
                        Satuan              : task.Satuan,
                        Tanggal_Selesai     : task.Tanggal_Selesai.split(' ')[0],
                        Persentase          : task.Persentase
                    }
                    // console.log(JSON.stringify(eachsubdiv, null, 2))
                    alltask.push(eachtask)
                    for(let subtask of task.Sub_Task.data){
                        let eachsubtask ={
                            Id_Sub_Item_Pekerjaan   : subtask.Id_Sub_Item_Pekerjaan,
                            Id_Item_Pekerjaan       : subtask.Id_Item_Pekerjaan,
                            Projek                  : data.Nama,
                            Divisi                  : div.Nama, 
                            Sub_Divisi              : subdiv.Nama,                     
                            Task                    : task.Nama,                     
                            Nama                    : subtask.Nama,
                            Kode                    : subtask.Kode,
                            Deskripsi               : subtask.Deskripsi,
                            Tanggal_Selesai         : subtask.Tanggal_Selesai.split(' ')[0],
                            Persentase              : subtask.Persentase,
                            User                    : '',
                            Remaining               : '',
                            Progress                : '0',
                            Status                  : 'untake',
                            Log_Pengerjaan          :[],

                        }
                        // console.log(JSON.stringify(eachsubdiv, null, 2))
                        for(let log of this.logPengerjaanData){
                            if(log.Id_Sub_Item_Pekerjaan == eachsubtask.Id_Sub_Item_Pekerjaan){
                                eachsubtask.Log_Pengerjaan.push(log)
                            }
                        }
                        let today = new Date().getTime();
                        let target = new Date(eachsubtask.Tanggal_Selesai).getTime();
                        let remaining = parseInt((target-today)/(24*3600*1000));
                        eachsubtask.Remaining = remaining +' days left'

                        // console.log(target)
                        
                        // console.log(remaining)
                        if(eachsubtask.Log_Pengerjaan.length > 0){
                            eachsubtask.Log_Pengerjaan = eachsubtask.Log_Pengerjaan.slice().reverse()
                            // console.log(eachsubtask.Log_Pengerjaan)
                            if(eachsubtask.Log_Pengerjaan.length==1)
                            {
                                eachsubtask.Progress = eachsubtask.Log_Pengerjaan[0].Progress 
                                eachsubtask.User = eachsubtask.Log_Pengerjaan[0].Username 
                            }
                            else{
                                let data = eachsubtask.Log_Pengerjaan.find(obj=>obj.Berkas!='' )
                                eachsubtask.Progress = data.Progress 
                                eachsubtask.User = data.Username 
                            }
                           
                            // eachsubtask.Progress = eachsubtask.Log_Pengerjaan[0].Progress 
                            // eachsubtask.User = eachsubtask.Log_Pengerjaan[0].Username 
                            
                        }
                        
                        if(remaining < 0 && eachsubtask.Progress != '100'){
                            eachsubtask.Status = 'overdue'
                            eachsubtask.Remaining = remaining +' days overdue'
                        }
                        else if(eachsubtask.Progress!='100'){
                            eachsubtask.Status = 'ongoing'
                        }
                        else{
                            eachsubtask.Status = 'complete'
                        }

                        allsubtask.push(eachsubtask)
                    }
                }
            }

        }
        data.All_Divisi     = alldivisi
        data.All_SubDivisi  = allsubdivisi
        data.All_Task       = alltask
        data.All_SubTask    = allsubtask
        // console.log(JSON.stringify(alldivision, null, 2))
        // console.log(JSON.stringify(allsubdivision, null, 2))

        // console.log(JSON.stringify(this.data, null, 2))
        // console.log(data.All_SubTask);
    
    },

    async sendAccessRequest(){
        try {
            let payload={
                Id_Akun : this.Id_Akun,
                Id_Sub_Item_Pekerjaan : this.editTask.Id_Sub_Item_Pekerjaan,
                Status : this.reqForm.Status,
                Deskripsi :this.reqForm.Deskripsi,
                Verifikasi :'Unverified'
            }
            // console.log(payload)
            const response= (await Controller.addjobakses(payload)).data
            // console.log(response)
            this.requestDialog=false
            this.showAlert('success','Sukses Mengirim Request')


        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Mengirim Request')

        }
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


            // console.log(payloadFile)

            const pathfile= (await Controller.uploadfile(payloadFile)).data
            // console.log(pathfile)
            let Id_Pengerjaan = (this.editTask.Log_Pengerjaan.find(obj => obj.Id_Akun == this.Id_Akun && obj.Berkas == '')).Id_Log_Pengerjaan
            // console.log(Id_Pengerjaan)

            let payload={
                Progress: this.editTask.Progress,
                Catatan : this.editTask.Note,
                Berkas  : pathfile,
            }
            const response= (await Controller.updatelogpengerjaan(payload,Id_Pengerjaan)).data
            await this.accessDone()
            this.removefile()
            let index = this.editTask.Log_Pengerjaan.findIndex(obj=>obj.Id_Log_Pengerjaan==response.Id_Log_Pengerjaan)
            Object.assign(this.editTask.Log_Pengerjaan[index], response)
            this.close()
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
            const response = await Controller.updatejobakses(payload,this.editTask.Id_Akses)

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

    addDivForm(){
        this.editProject.All_Divisi.push(this.divform)
        this.divform = Object.assign({}, this.defaultdivform)

    },
    delDivForm(index){
        this.editProject.All_Divisi.splice(this.editProject.All_Divisi.indexOf(index), 1)
        this.editProject.All_Divisi = [...this.editProject.All_Divisi]
       
    },

    addSubDivForm(){
        this.editProject.All_SubDivisi.push(this.subdivform)
        this.subdivform = Object.assign({}, this.defaultsubdivform)

    },
    delSubDivForm(index){
        this.editProject.All_SubDivisi.splice(this.editProject.All_SubDivisi.indexOf(index), 1)
        this.editProject.All_SubDivisi = [...this.editProject.All_SubDivisi]
       
    },

    addTaskForm(){
        this.editProject.All_Task.push(this.taskform)
        this.taskform = Object.assign({}, this.defaulttaskform)

    },
    delTaskForm(index){
        this.editProject.All_Task.splice(this.editProject.All_Task.indexOf(index), 1)
        this.editProject.All_Task = [...this.editProject.All_Task]
       
    },
    addSubTaskForm(){
        this.editProject.All_SubTask.push(this.subtaskform)
        this.subtaskform = Object.assign({}, this.defaultsubtaskform)

    },
    delSubTaskForm(index){
        this.editProject.All_SubTask.splice(this.editProject.All_SubTask.indexOf(index), 1)
        this.editProject.All_SubTask = [...this.editProject.All_SubTask]
       
    },

    addProject(data){
        this.projects.push(data);
    },
    editProjectDialog(project){
        this.editProject = Object.assign({},project)
        this.editmode=true
        this.addDialog2=true
    },
    async detailProjectDialog(project){
        this.detailProject = Object.assign({},project)
        this.detailProject.Remaining = parseInt((new Date(this.detailProject.Target_Outcome).getTime()-new Date().getTime())/(24*3600*1000)) +' days left'
        // this.detailProject.Progress = await Controller.getProgressProyek(this.detailProject.Id_Proyek)
        this.detailProject.Progress = 0


        for(let subtask of this.detailProject.All_SubTask){

            subtask.Remaining = parseInt((new Date(subtask.Tanggal_Selesai).getTime()-new Date().getTime())/(24*3600*1000)) +' days left'
        }

        for(let task of this.detailProject.All_Task){

            task.Remaining = parseInt((new Date(task.Tanggal_Selesai).getTime()-new Date().getTime())/(24*3600*1000)) +' days left'
            task.Progress =0
            for(let subtask of this.detailProject.All_SubTask.filter(obj=>obj.Task == task.Nama)){
                    
                  task.Progress +=  subtask.Progress * subtask.Persentase/100
            }

            // task.Progress= await Controller.getProgressItem(task.Id_Item_Pekerjaan)
        }

        for(let subdiv of this.detailProject.All_SubDivisi){

            subdiv.Remaining = parseInt((new Date(subdiv.Tanggal_Selesai).getTime()-new Date().getTime())/(24*3600*1000)) +' days left'
            // subdiv.Progress= await Controller.getProgressSubDivisi(subdiv.Id_Sub_Divisi_Proyek)
            subdiv.Progress =0
            for(let task of this.detailProject.All_Task.filter(obj=>obj.Sub_Divisi == subdiv.Nama)){
                   
                  subdiv.Progress +=  task.Progress * task.Persentase/100
            }

        }

        for(let div of this.detailProject.All_Divisi){

            div.Remaining = parseInt((new Date(div.Tanggal_Selesai).getTime()-new Date().getTime())/(24*3600*1000)) +' days left'
            // div.Progress= await Controller.getProgressDivisi(div.Id_Divisi_Proyek)
            div.Progress =0
            for(let subdiv of this.detailProject.All_SubDivisi.filter(obj=>obj.Divisi == div.Nama)){
                    
                  div.Progress +=  subdiv.Progress * subdiv.Persentase/100
            }
            this.detailProject.Progress += div.Progress * div.Persentase/100
        }

        this.detailDialog = true


    },
    addTask(data){
        console.log(data)
        // Object.assign(this.editProject.tasks[0],data)

        this.editProject.tasks.push(this.editTask);
        // this.editProject.tasks.push(Object.assign({}, data));
    },
    closeAddDialog(){
        this.addDialog2=false;
        this.editProject = Object.assign({},this.initEditProject)
        this.templateProject=''

        // this.editProject.tasks=[]
        // this.editTask = Object.assign({},this.initEditTask)

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
    openTaskDialog(data){
      this.taskDialog=true
      this.editTask=data
      this.editTask.Status_Akses = 'Locked' //<==================================NEED EDIT

      for(let akses of this.jobAksesData)
      {
          if(akses.Id_Sub_Item_Pekerjaan == data.Id_Sub_Item_Pekerjaan && akses.Verifikasi=="Verified" && akses.Id_Akun == this.Id_Akun)
          {
              this.editTask.Status_Akses = akses.Status
              this.editTask.Id_Akses = akses.Id_Akses_Pekerjaan
              
          }
      }

    //   console.log(this.editTask.Log_Pengerjaan.filter(obj=>obj.Berkas!=''))

    },

    getSubDivision(){
        this.sub_division=this.data_sub_division.filter(obj=>obj.division == this.filterDiv)
        this.filterSubDiv=''
       
    },
    getTask(){
        this.task=this.data_task.filter(obj=>obj.sub_division == this.filterSubDiv)
        this.filterTask=''

    },
    filteredTask(data){
        if(this.filterDiv!="")
        {
            // console.log("in")
            if(this.filterSubDiv!="")
            {
                if(this.filterTask!="")
                {
                    return data.filter(obj=>obj.Division==this.filterDiv && obj.Sub_Division==this.filterSubDiv && obj.Task==this.filterTask )

                }
                else{
                    return data.filter(obj=>obj.Division==this.filterDiv && obj.Sub_Division==this.filterSubDiv)
                    
                }
            }
            else{
                return data.filter(obj=>obj.Division==this.filterDiv)
            }
        }
        else 
        {
            return data
        }
    },

    clearFilter(){
        this.filterDiv=''
        this.filterSubDiv=''
        this.filterTask=''

    },

    pickFile () {
        if(this.file=='')
        {
            this.$refs.file.click ()
        }
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
      this.editTask.Status_Akses ='Locked'
   

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
        
    }

    // sortByDate(prop){
    //   this.projects.sort((a, b) => new Date(a.due) - new Date(b.due))
    // }
  }
}

</script>

<style>

.d_div{
  border-left: 4px solid #3cd1c2 !Important;
  border-color:#3cd1c2 !Important;
}
.d_sub_div{
  border-left: 4px solid #00B8D4 !Important;
  border-color:#00B8D4 !Important;
}

.d_task{
  border-left: 4px solid #0091EA !Important;
  border-color:#0091EA !Important;
}

/* .d_sub_task{
  border-left: 4px solid #004D40 !Important;
  border-color:#004D40 !Important;
} */


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