<template>
    <v-container fluid grid-list-xl>
      <v-container fluid py-0>
          <v-tabs
              v-model="tab"
              background-color="deep-purple accent-4"
              class="elevation-2"
              dark
              :centered="centered"
              :grow="grow"
              :vertical="vertical"
              :right="right"
              :icons-and-text="icons"
          >
              <v-tab-slider></v-tab-slider>
              <v-tab>Project</v-tab>
              <v-tab>Employee</v-tab>
              <!-- ITEM PROJECT -->
              <v-tab-item>
                <v-container fluid>
                  <v-layout row wrap>
                    <v-flex xs12 md12>
                      <v-layout justify-start class="mb-2 pa-3">
                        <h3 style="border-bottom:white solid 3px;">PROJECT LIST</h3>
                      </v-layout>
                      <v-select
                      :items="project_status"
                      v-model="filter_status"
                      item-text="Status"
                      item-value="Status"
                      box
                      label="Status"
                      style="max-width:200px"
                      >
                      </v-select>
                      <!-- Expand Panel -->
                      <v-expansion-panel >
                        <v-expansion-panel-content
                        v-for="project in filteredProject(this.projects)" 
                        :key="project.Nama"
                        expand-icon="mdi-menu-down"
                        >
                        <template v-slot:header>
                          <v-layout row wrap :class="`pa-3`" @click="getItemData(project)">
                              <v-flex xs12 md4 >
                                  <div class="caption grey--text">Project Title</div>
                                  <div>{{project.Nama}}</div>
                              </v-flex>
                              <v-flex xs6 sm4 md2>
                                  <div class="caption grey--text">Due Date</div>
                                  <div>{{project.Tanggal_Selesai}}</div>
                              </v-flex>   
                              <v-spacer/>
                              <v-flex>
                                  <v-btn small @click="openProjectNotesDialog(project)">Notes</v-btn>
                                  <v-btn small>Detail</v-btn>
                                  <v-btn small>Restore</v-btn>
                                  <v-btn small>Delete</v-btn>
                              </v-flex>  
                              <!-- <v-flex>
                                  <v-btn small @click="editProjectDialog(project)">Edit</v-btn>
                              </v-flex>   -->
                          </v-layout>
                        </template>

                        <v-card class="grey darken-2">
                            <v-container class="pa-3">
                            <v-card class="pa-2">
                                <v-card-title>
                                    <span>Filter</span>
                                </v-card-title>
                                <!-- <v-layout row wrap>
                                  <v-flex class="px-1" xs12 sm12 md2 >
                                    <v-select
                                    v-model="filterDiv"
                                    :items="project.All_Divisi"
                                    item-text="Nama"
                                    item-value="Nama"
                                    box
                                    label="Division"
                                    @change="getSubDivision(project)"
                                    ></v-select>
                                  </v-flex>
                                  <v-flex class="px-1" xs12 sm12 md2 >
                                    <v-select
                                    v-model="filterSubDiv"
                                    :items="sub_division"
                                    item-text="Nama"
                                    item-value="Nama"
                                    box
                                    label="Sub Division"
                                    @change="getTask(project)"
                                    ></v-select>
                                  </v-flex>     
                                  <v-flex class="px-1" xs12 sm12 md2 >
                                    <v-select
                                    v-model="filterTask"
                                    :items="task"
                                    item-text="Nama"
                                    item-value="Nama"
                                    box
                                    label="Task"
                                    ></v-select>
                                  </v-flex>
                                  <v-flex class="px-1" xs12 sm6 md2 >
                                    <v-btn  @click="clearFilter()">Clear</v-btn>
                                  </v-flex>
                                </v-layout>  -->
                            </v-card>   
                            <v-card hover v-ripple class="px-3 scroll-y" v-for="subtask in project_card.All_SubTask" :key="subtask.Nama" flat style="background: #424242 !important;" @click="openTaskDialog(subtask)">
                              <v-layout row wrap :class="`pa-3  project ${subtask.Color}`">
                                  <v-flex xs12 md2>
                                      <div class="caption grey--text">{{subtask.Divisi}}</div>
                                      <div>{{subtask.Sub_Divisi}}</div>
                                  </v-flex>
                                  <v-flex xs6 sm4 md3>
                                      <div class="caption grey--text">{{subtask.Task}}</div>
                                      <div>{{subtask.Nama}}</div>
                                  </v-flex>     
                                  <v-flex xs6 sm4 md2>
                                      <div class="caption grey--text">Due Date</div>
                                      <div>{{subtask.Tanggal_Selesai}}</div>
                                  </v-flex>
                                  <v-flex xs6 sm4 md2> 
                                      <div class="caption grey--text">Progress</div>
                                      <div>
                                          <v-progress-linear
                                          color="red"
                                          height="20"
                                          style="top:-11px"
                                          :value="subtask.Total_Progress"
                                          >
                                          <p class="text-xs-center">{{subtask.Total_Progress}}%</p>
                                          </v-progress-linear>
                                      </div>
                                  </v-flex>
                                  <v-flex xs2 sm4 md3>
                                      <!-- <div class="caption grey--text">Status</div> -->
                                      <div align="center" justify="center">
                                          <v-chip small style="top:13px" :class="` white--text my-2 caption ${subtask.Color}`">{{subtask.Work_Status}}</v-chip>
                                      <!-- </div>
                                      <div align="center" justify="center"> -->
                                          <v-chip small style="top:13px" :class="` white--text my-2 caption ${subtask.Color}`">{{subtask.Time_Status}}</v-chip>
                                      </div>
                                  </v-flex>
                              </v-layout>
                              <v-divider></v-divider>
                              </v-card>
                            </v-container>
                        </v-card>
                        </v-expansion-panel-content>
                      </v-expansion-panel>
                      <!-- Expand Panel -->
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-tab-item>
              <!-- ITEM EMPLOYEE -->
              <v-tab-item>

              </v-tab-item>
              <!-- ITEM EMPLOYEE -->
          </v-tabs>
      </v-container>
      <!-- Task Dialog -->
      <v-layout row justify-center>
        <v-dialog v-model="taskDialog" scrollable persistent max-width="600px">
          <v-card>
              <v-card-title>
                  <span class="headline">{{editTask.Nama}}</span>
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
                  <v-flex xs12 md5>
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
                  <v-spacer></v-spacer>
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
                  <v-flex xs12 md2>
                    <v-text-field
                        :value="parseInt(editTask.Total_Progress)+'%'"
                        label="Total"
                        prepend-icon="timeline"
                        type="text"
                        readonly
                    ></v-text-field>
                  </v-flex>
                  <v-spacer></v-spacer>
                  <v-flex xs12 md9>
                    <v-progress-linear
                      color="red"
                      height="20"
                      :value="parseInt(editTask.Total_Progress)"
                      label="progress"
                      >
                      <p class="text-xs-center">{{parseInt(editTask.Total_Progress)}}%</p>
                      </v-progress-linear>
                  </v-flex>
                  <!-- Progress -->

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
                              </v-flex>
                            </v-layout>
                          </v-list-tile-action>
                      </v-list-tile>
                    </v-list>
                  </v-flex>
                  <!-- Log Progress -->

                  </v-layout>
              </v-container>
              
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                <!-- <span> Status : {{editTask.Status_Akses}}</span>    -->
              <v-spacer></v-spacer>

              <v-btn color="blue darken-1" flat @click="close()">Close</v-btn>
              <v-btn color="blue darken-1" flat v-if="editTask.Total_Progress == 100"  @click="openPerformanceDialog(editTask)">Performance</v-btn>
              <!-- <v-btn color="blue darken-1" v-if="editTask.status=='untake'" flat @click="taskDialog = false">Request</v-btn>
              <v-btn color="blue darken-1" v-else flat @click="taskDialog = false">Save</v-btn> -->

              </v-card-actions>
          </v-card>
          </v-dialog>
      </v-layout>
      <!-- Task Dialog -->
      <!-- Project Note Dialog -->
      <v-layout row justify-center>
          <v-dialog v-model="projectNoteDialog" scrollable persistent max-width="600px">
          <v-card>
              <v-card-title>
                  <span class="headline">{{projectNote.Nama}}</span>
                  <v-spacer/>
              </v-card-title>
              <v-divider/>
                  <span class="headline mx-auto mt-3">Project Note</span>
              <v-card-text>
              <v-container grid-list-md>
                  <v-layout wrap>
                      <!-- Notes -->
                      <v-flex xs12>
                          <v-textarea
                          outline
                          readonly
                          label="Project Note"
                          v-model="projectNote.Catatan"
                          rows="14"
                          ></v-textarea>
                      </v-flex>
                      <!-- Notes -->
                  <!-- Description -->
                  </v-layout>
              </v-container>
              
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn color="blue darken-1" flat @click="projectNoteDialog = false">Close</v-btn>
              </v-card-actions>
          </v-card>
          </v-dialog>
      </v-layout>
      <!-- Project Note Dialog -->
      <!-- Performance Dialog -->
      <v-layout row justify-center>
          <v-dialog v-model="performanceDialog" scrollable persistent max-width="300px">
          <v-card>
              <v-card-title>
                  <span style="font-size:18px;">Performance</span>
                  <v-spacer/>
              </v-card-title>
              <v-divider/>
              <v-card-text>
              <!-- <v-container grid-list-md> -->
                  <v-layout wrap>
                      <!-- Notes -->
                      <v-flex xs12 @click="getPerformaceStatus()">
                        <div align="center">
                          <v-rating
                            v-model="performance.Rating"
                            :length="performance.length"
                            :empty-icon="performance.emptyIcon"
                            :full-icon="performance.fullIcon"
                            :half-increments="performance.halfIncrements"
                            :hover="performance.hover"
                            :readonly="performance.readonly"
                            :size="performance.size"
                            :dense="performance.dense"
                            :color="performance.color"
                            :background-color="performance.bgColor"
                          ></v-rating>
                            <span class="mx-auto mt-3" style="font-size:14px" align="center">{{performance.Keterangan}}</span>
                        </div>
                      </v-flex>
                      <!-- Notes -->
                  <!-- Description -->
                  </v-layout>
              <!-- </v-container> -->
              
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn color="blue darken-1" flat @click="performanceDialog = false">Close</v-btn>
              <v-btn color="blue darken-1" flat @click="savePerformance(editTask)" :loading="savePerformanceLoading">Save</v-btn>
              </v-card-actions>
          </v-card>
          </v-dialog>
      </v-layout>
      <!-- Performance Dialog -->
      <!-- Alert -->
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
        <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
      <!-- Alert -->
    </v-container>
</template>
<script>
import Controller from '../httpController'
import { mapGetters } from 'vuex'
// import * as easings from 'vuetify/es5/services/goto/easing-patterns'

export default {
  data: () => ({
    //Select
    project_status : [
    { Status : "All" },
    { Status : "Finished" },
    { Status : "On Going" },
    ],
    //Select
    //Alerts
    alert:{
        type: null,
        message: null,
        icon: null,
    },
    //Alerts
    //Tabs
    tab: null,
    icons: false,
    centered: false,
    grow: true,
    vertical: false,
    prevIcon: false,
    nextIcon: false,
    right: false,
    tabs: 1,
    //Tabs
    //Projects
    project_card:[],
    projects:[],
    d_projects : [
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
                Nama:'Denah Depan Denah Depan Denah Depan Denah Depan Denah Depan ',
                Divisi:'Perencanaan',
                Sub_Divisi:"Desain",
                Task:'Desain Skematik',
                Persentase:'50',
                Tanggal_Selesai:'2020-10-12',
                Deskripsi:'A',
                Kode:'STSK1',
                Total_Progress : 80,
                Work_Status:'On Going',
                Time_Status:'In Time',
                Color:'ggreen',
                Remaining:'12 days remaining',
            },
            {
                Nama:'Denah Belakang Denah Belakang Denah Belakang Denah Belakang ',
                Divisi:'Perencanaan',
                Sub_Divisi:"Desain",
                Task:'Desain Skematik',
                Persentase:'50',
                Tanggal_Selesai:'2020-10-12',
                Deskripsi:'A',
                Kode:'STSK1',
                Total_Progress:100,
                Work_Status:'On Going',
                Time_Status:'In Time',
                Color:'bblue',
                Remaining:'10 days remaining',
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
    ],
    logPengerjaanData:[],
    //Projects

    //DIALOG
    //Task Dialog
    taskDialog:false,
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
        Progress                : 0,
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
    //Task Dialog

    //Date Dialog
    dateDialog:false,
    //Date Dialog

    //Note Dialog
    noteDialog:false,
    noteText:'',
    noteUser:'',
    //Note Dialog

    // Project Note Dialog
    projectNoteDialog:false,
    projectNote : {
        Nama : '',
        Catatan : '',
    },
    // Project Note Dialog
    
    //Performance Dialog
    performanceDialog:false,
    //Performance Dialog
    //Filter
    filter_status:'',
    filterDiv:'',
    filterSubDiv:'',
    filterTask:'',
    //Filter
    //Performance Rating
    //DATA
    performance:{
      Nama :'',
      Rating : 0,
      Keterangan: '',
      emptyIcon: 'mdi-star-outline',
      fullIcon: 'mdi-star',
      halfIncrements: false,
      hover: true,
      length: 4,
      readonly: false,
      size: 32,
      dense: false,
      color: 'grey darken-1',
      bgColor: 'grey lighten-1',
    },
    initPerformance:{
      Nama :'',
      Rating : 0,
      Keterangan: '',
      emptyIcon: 'mdi-star-outline',
      fullIcon: 'mdi-star',
      halfIncrements: false,
      hover: true,
      length: 4,
      readonly: false,
      size: 32,
      dense: false,
      color: 'grey darken-1',
      bgColor: 'grey lighten-1',
    },
    //DATA
    //Performance Rating

    //LOADING
    savePerformanceLoading:false,
    //LOADING
  }),
  computed : {
    ...mapGetters({
        id_akun:'LoggedUser/Id_Akun',
        nama: 'LoggedUser/Name',
        akses:'LoggedUser/Akses',
    }),
  },
  mounted () {
    this.loaddata ()
  },
  methods : {
    async loaddata ()
    {
      // try {
      //     let data = (await Controller.getallproject()).data
      //     this.logPengerjaanData = (await Controller.getalllogpengerjaan()).data

      //     for(let item of data)
      //     {
      //         this.getDataFormat(item)
      //     }
      //     this.projects=data
      // } catch (err) {
      //     console.log(err)
      // }
      try {
        let data = (await Controller.getallproject())
        for(let project of data)
        {
          project.isGetDataFormat = false;
          // let pro = (await Controller.getoneproject(project.Id_Proyek)).data
          // this.getDataFormat(pro)
          // console.log(pro)
        }
        
        this.projects = data
        this.getItemData(this.projects[0])
        console.log(this.projects)
      } catch (err) {
        console.log(err)
      }
    },
    //GET DATA
    async getItemData(item)
    {
      console.log("item")
      console.log(item)
      this.project_card = []
      if(item.isGetDataFormat == false)
      {
        let index = this.projects.indexOf(item)
        let project = (await Controller.getoneproject(item.Id_Proyek)).data
        this.getDataFormat(project)
        this.projects[index] = Object.assign({}, project)
        this.projects[index]=project
        console.log("CEK")
        this.project_card = this.projects[index];
        console.log(this.projects)
      }
      else
      {
        let index = this.projects.indexOf(item)
        // let project = (await Controller.getoneproject(item.Id_Proyek)).data
        // this.getDataFormat(project)
        // this.projects[index] = Object.assign({}, project)
        // this.projects[index]=project
        // console.log("CEK")
        this.project_card = this.projects[index];
        console.log(this.projects)
      }
    },
    // itemData(){
    //   return this.projects[0];
    // },
    async getDataFormat(data){
      if(this.logPengerjaanData.length == 0)
        this.logPengerjaanData = (await Controller.getalllogpengerjaan()).data
      let alldivisi =[]
      let allsubdivisi=[]
      let alltask=[]
      let allsubtask=[]

      let PersentaseProyek = 0
      let PersentaseDivisi = 0
      let PersentaseSubDivisi = 0
      let PersentaseTask = 0

      for(let div of data.Divisi.data)
      {    
          for(let subdiv of div.Sub_Divisi.data)
          {
              for(let task of subdiv.Task.data)
              {
                  for(let subtask of task.Sub_Task.data)
                  {
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
                          Total_Progress          : '0',
                          Progress                : '0',
                          Work_Status             : 'untake',
                          Time_Status             : 'in time',
                          Color                   : 'grey',
                          Log_Submitted           : '',
                          Log_Pengerjaan          :[],
                          Prestasi_Kerja          : subtask.Prestasi_Kerja
                      }
                      for(let log of this.logPengerjaanData){
                          if(log.Id_Sub_Item_Pekerjaan == eachsubtask.Id_Sub_Item_Pekerjaan){
                              eachsubtask.Total_Progress = parseInt(log.Progress)+parseInt(eachsubtask.Total_Progress)
                              eachsubtask.Log_Submitted = log.Waktu_Selesai.split(' ')[0],
                              eachsubtask.Log_Pengerjaan.push(log)
                          }
                      }
                      let today = new Date().getTime();
                      let target = new Date(eachsubtask.Tanggal_Selesai).getTime();
                      let remaining = parseInt((target-today)/(24*3600*1000));
                      eachsubtask.Remaining = remaining +' days left'
                      
                      let filteredlog = this.logPengerjaanData.filter(obj=>obj.Id_Sub_Item_Pekerjaan == eachsubtask.Id_Sub_Item_Pekerjaan)

                      if(filteredlog.length == 0)
                      {
                        eachsubtask.Work_Status = 'Available'
                        if(remaining<0)
                        {
                          eachsubtask.Time_Status = 'Overdue'
                          eachsubtask.Color = 'rred'
                          eachsubtask.Remaining = remaining +' days overdue'
                        }
                        else if (remaining==0)
                        {
                          eachsubtask.Time_Status = 'On Time'
                          eachsubtask.Color = 'yyellow';
                        }
                        else
                        {
                          eachsubtask.Color = 'ggrey';
                          eachsubtask.Time_Status = 'In Time'
                        }
                      }
                      else
                      {
                        if(eachsubtask.Total_Progress != '100')
                        {
                          eachsubtask.Work_Status = 'On Going'
                          if(remaining<0)
                          {
                            eachsubtask.Time_Status = 'Overdue'
                            eachsubtask.Color = 'rred'
                            eachsubtask.Remaining = remaining +' days overdue'
                          }
                          else
                          {
                            eachsubtask.Time_Status = 'In Time'
                            eachsubtask.Color = 'ggreen'
                          }
                        }
                        else
                        {
                          eachsubtask.Work_Status = 'Complete'
                          let submitted = new Date(eachsubtask.Log_Submitted).getTime();
                          let diff = parseInt((target-submitted)/(24*3600*1000))
                          if(diff<0)
                          {
                            eachsubtask.Time_Status = 'Overdue'
                            eachsubtask.Color = 'rred'
                            eachsubtask.Remaining = remaining +' days overdue'
                          }
                          else
                          {
                            eachsubtask.Time_Status = 'On Time'
                            eachsubtask.Color = 'bblue'
                          }
                        }
                      }
                      PersentaseTask += subtask.Persentase;
                      allsubtask.push(eachsubtask)
                  }
                  let eachtask ={
                    Id_Item_Pekerjaan   : task.Id_Item_Pekerjaan,
                    Id_Divisi_Role      : task.Id_Divisi_Role, 
                    Id_Sub_Divisi_Proyek: task.Id_Sub_Divisi_Proyek,
                    Sub_Divisi          : task.Sub_Divisi,                        
                    Nama                : task.Nama,
                    Kode                : task.Kode,
                    Satuan              : task.Satuan,
                    Tanggal_Selesai     : task.Tanggal_Selesai.split(' ')[0],
                    Persentase          : task.Persentase,
                    Total_Persentase    : PersentaseTask,
                  }
                  alltask.push(eachtask)
                  PersentaseTask = 0
                  PersentaseSubDivisi += task.Persentase
              }
              let eachsubdiv ={
                  Id_Sub_Divisi_Proyek    : subdiv.Id_Sub_Divisi_Proyek,
                  Id_Divisi_Proyek        : subdiv.Id_Divisi_Proyek,
                  Divisi                  : subdiv.Divisi,
                  Nama                    : subdiv.Nama,
                  Tanggal_Selesai         : subdiv.Tanggal_Selesai.split(' ')[0],
                  Persentase              : subdiv.Persentase,
                  Total_Persentase        : PersentaseSubDivisi,
              }
              allsubdivisi.push(eachsubdiv)
              PersentaseSubDivisi = 0
              PersentaseDivisi += subdiv.Persentase
          }
          let eachdiv ={
              Id_Divisi_Proyek    : div.Id_Divisi_Proyek,
              Id_Divisi_Role      : div.Id_Divisi_Role,
              Id_Proyek           : div.Id_Proyek,
              Nama                : div.Nama,
              Tanggal_Selesai     : div.Tanggal_Selesai.split(' ')[0],
              Persentase          : div.Persentase,
              Total_Persentase    : PersentaseDivisi,
          }
          alldivisi.push(eachdiv)
          PersentaseDivisi = 0
          PersentaseProyek += div.Persentase
      }
      data.All_Divisi     = alldivisi
      data.All_SubDivisi  = allsubdivisi
      data.All_Task       = alltask
      data.All_SubTask    = allsubtask
      data.Total_Persentase = PersentaseProyek
      data.isGetDataFormat = true
      // if(data.c)
      console.log(data)
    },
    //***********GET DATA***********\\

    //***********POST DATA***********\\

    //***********POST DATA***********\\

    //***********UPDATE DATA***********\\
    async savePerformance(data){
        try{
            
            this.savePerformanceLoading=true;
            for(let subtask of this.project_card.All_SubTask)
            {
              if(subtask.Id_Sub_Item_Pekerjaan == data.Id_Sub_Item_Pekerjaan)
              {
                subtask.Prestasi_Kerja = this.performance.Rating
              }
            }
            let response = (await Controller.updateproject(this.project_card,this.project_card.Id_Proyek).then(()=>{this.savePerformanceLoading=false;}))
            this.close()
            this.showAlert('success','Save Performance Success')

        }catch (err) {
            console.log(err)
            (this.showAlert('error','Save Performance Failed'))
            this.savePerformanceLoading=false;

        }
    },
    //***********UPDATE DATA***********\\

    //***********DELETE DATA***********\\


    //***********DELETE DATA***********\\

    //***********OPEN DIALOG***********\\
    openTaskDialog(data){
      this.taskDialog=true
      this.editTask=data
    },
    openProjectNotesDialog(project){
        this.projectNoteDialog = true
        this.projectNote.Nama = project.Nama
        this.projectNote.Catatan = project.Catatan
    },
    openPerformanceDialog(data){
        console.log("MASUK");
        console.log(data);
        this.performanceDialog = true
        this.performance.Nama = data.Nama
        this.performance.Rating = data.Prestasi_Kerja

        if(this.performance.Rating == 1)
        {
          this.performance.Keterangan = 'Bad Performance'
          this.performance.color = 'red'
          this.performance.bgColor = 'red lighten-1'
        }
        if(this.performance.Rating == 2)
        {
          this.performance.Keterangan = 'Semi Performance'
          this.performance.color = 'yellow'
          this.performance.bgColor = 'yellow lighten-1'
        }
        if(this.performance.Rating == 3)
        {
          this.performance.Keterangan = 'Performance'
          this.performance.color = 'green'
          this.performance.bgColor = 'green lighten-1'
        }
        if(this.performance.Rating == 4)
        {
          this.performance.Keterangan = 'Best Performance'
          this.performance.color = 'blue'
          this.performance.bgColor = 'blue lighten-1'
        }
    },
    // ***********Close Dialog***********\\
    // closePerformanceDialog()
    // {
    //   performanceDialog=false;
    //   Object.assign(this.editTask.Log_Pengerjaan[index], response)
    // },
    //***********FILTER***********\\
    filteredProject(data)
    {
      if(this.filter_status!="")
      {
        if(this.filter_status == 'All')
        {
          return data
        }
        else if(this.filter_status == 'Finished')
        {
          console.log("SINI")
          return data.filter(obj=>obj.deleted_at != null)
        }
        else
        {
          return data.filter(obj=>obj.deleted_at == null)
        }
      }
      else
      {
        return data
      }

    },
    //***********FILTER***********\\
    
    //***********FILES***********\\
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
        if(this.fileName.lastIndexOf('.') <= 0) {
          return
        }
        const fr = new FileReader ()
        fr.readAsDataURL(files[0])
        fr.addEventListener('load', () => {
          this.fileUrl = fr.result
          this.file = files[0]
          this.namefile.push(this.file.name)
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
        url: 'http://192.168.1.71:8000/'+data.Berkas,
        responseType: 'arraybuffer'
      })
      .then(response => {
       this.forceFileDownload(response,data)  
      })
      .catch(() => console.log('error occured'))
      
    },

    //***********FILES***********\\
    
    //***********OTHERS***********\\
    getPerformaceStatus()
    {
      console.log("MASUK")
      
      // performance:{
      // Nama :'',
      // Rating : 0,
      // Keterangan: 'TES',
      // emptyIcon: 'mdi-star-outline',
      // fullIcon: 'mdi-star',
      // halfIncrements: false,
      // hover: true,
      // length: 4,
      // readonly: false,
      // size: 64,
      // dense: false,
      // color: 'grey darken-1',
      // bgColor: 'grey lighten-1',

      if(this.performance.Rating == 1)
      {
        this.performance.Keterangan = 'Bad Performance'
        this.performance.color = 'red'
        this.performance.bgColor = 'red lighten-1'
      }
      if(this.performance.Rating == 2)
      {
        this.performance.Keterangan = 'Semi Performance'
        this.performance.color = 'yellow'
        this.performance.bgColor = 'yellow lighten-1'
      }
      if(this.performance.Rating == 3)
      {
        this.performance.Keterangan = 'Performance'
        this.performance.color = 'green'
        this.performance.bgColor = 'green lighten-1'
      }
      if(this.performance.Rating == 4)
      {
        this.performance.Keterangan = 'Best Performance'
        this.performance.color = 'blue'
        this.performance.bgColor = 'blue lighten-1'
      }
      console.log(this.performance.Keterangan)
    },
    close () {
        setTimeout(() => {
            this.performanceDialog=false;
            this.taskDialog=false
            this.performance = Object.assign({}, this.initPerformance)
            // this.performance.color='grey darken-1'
            // this.performance.bgColor= 'grey lighten-1'
            // this.performance.Nama=''
            // this.performance.Rating=0
            // this.performance.Keterangan=''
        }, 300)
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
    //***********OTHERS***********\\
  }
}
</script>
<style>
 .d_div{
  border-left: 4px solid #0277BD !Important;
  border-color:#0277BD !Important;
}
.d_sub_div{
  border-left: 4px solid #0091EA !Important;
  border-color:#0091EA !Important;
}

.d_task{
  border-left: 4px solid #00B8D4 !Important;
  border-color:#00B8D4 !Important;
}

.d_sub_task{
   border-left: 4px solid #3cd1c2 !Important;
  border-color:#3cd1c2 !Important;
}

/* .d_div{
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

.d_sub_task{
  border-left: 4px solid #0277BD !Important;
  border-color:#0277BD !Important;
} */

.project{
  border-radius: 5px;
  margin-top:0px !important;
}

.project.bblue{
  border-left: 4px solid #2196f3 !important;
  border-color:#2196f3 !important;
}
.project.ggreen{
  border-left: 4px solid #4caf50 !important;
  border-color:#4caf50 !important;
}
.project.rred{
  border-left: 4px solid #ff5252 !important;
  border-color:#ff5252 !important;
}
.project.ggrey{
  border-left: 4px solid #78909C !important;
  border-color:#78909C !important;
}


.v-chip.bblue{
  background: #2196f3 !important;
}
.v-chip.ggreen{
  background: #4caf50 !important;
}
.v-chip.rred{
  background: #ff5252 !important;
}
.v-chip.ggrey{
  background: #78909C !important;
}

</style>
