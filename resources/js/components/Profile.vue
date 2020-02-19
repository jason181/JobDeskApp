<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >
      <v-flex
        xs12
        md8
      >
        <v-layout 
          justify-center
          wrap
        >
          <v-flex
            xs12
            md6
          >
            <v-card
              flat
              tile
              class="pr-1 py-3 pl-3"
            >
              <template>
                <v-card
                  class="mt-4 mx-auto"
                  max-width="400"
                >
                  <v-sheet
                    class="v-sheet--offset mx-auto"
                    color="blue"
                    elevation="12"
                    max-width="calc(100% - 32px)"
                  >
                    <v-sparkline
                      :labels="labels"
                      :value="values"
                      color="white"
                      line-width="2"
                      padding="16"
                    ></v-sparkline>
                  </v-sheet>

                  <v-card-text class="pt-0">
                    <div class="title font-weight-light mb-2">Total Project : {{Total_Project}}</div>
                    <div class="subheading font-weight-light">Average Contribution : {{Average_Contribution}}%</div>
                    <v-divider class="my-2"></v-divider>
                    <v-icon
                      class="mr-2"
                      small
                    >
                      mdi-clock
                    </v-icon>
                    <span class="caption grey--text font-weight-light">last upload 26 minutes ago</span>
                  </v-card-text>
                </v-card>
              </template>
            </v-card>
          </v-flex>
          <v-flex
            xs12
            md6
          >
            <v-card
              flat
              tile
              class="pl-1 py-3 pr-3"
            >
              <template>
                <v-card
                  class="mt-4 mx-auto"
                  max-width="400"
                >
                  <v-sheet
                    class="v-sheet--offset mx-auto"
                    color="blue"
                    elevation="12"
                    max-width="calc(100% - 32px)"
                  >
                    <v-sparkline
                      :labels="labels"
                      :value="values"
                      color="white"
                      line-width="2"
                      padding="16"
                    ></v-sparkline>
                  </v-sheet>

                  <v-card-text class="pt-0">
                    <div class="title font-weight-light mb-2">Total Hari Kerja : 398</div>
                    <div class="subheading font-weight-light">Persentase Kehadiran : 98%</div>
                    <v-divider class="my-2"></v-divider>
                    <v-icon
                      class="mr-2"
                      small
                    >
                      mdi-clock
                    </v-icon>
                    <span class="caption grey--text font-weight-light">last Fingerprint 2 days ago</span>
                  </v-card-text>
                </v-card>
              </template>
            </v-card>
          </v-flex>
        </v-layout>
        <v-form>
          <v-container py-0>
            <div>
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
                <v-tabs-slider></v-tabs-slider>

                <v-tab @click="$vuetify.goTo(target, options)" id="Productivity">My Productivity</v-tab>
                <v-tab @click="$vuetify.goTo(target, options)" id="Productivity">Attendance</v-tab>
                <v-tab-item >
                  <v-container fluid>
                    <v-layout row wrap>
                      <v-flex xs12 md12  >
                        <v-card color="grey darken-2" height="100%" style="margin:4px;">
                            <v-card-title class="justify-center">
                                <span class="headline">Project Contribution</span>
                            </v-card-title>
                            <v-card-text> 
                                <v-btn small  @click="expandDetail = !expandDetail" slot="activator">
                                    <v-icon small left>filter_list</v-icon>
                                    <span class="caption ">Expand</span>
                                </v-btn>
                                <v-list expand style="height: 100%; min-height:350px;">
                                    <v-list-group
                                    v-for="project in UserProjects"
                                    :key="project.Id_Proyek"
                                    class="px-2"
                                    :value="expandDetail">
                                      <template v-slot:activator>
                                        <v-list-tile class="d_project">
                                            <v-list-tile-content style="height:50px">
                                                <v-list-tile-title style="height:35px;line-height:35px">
                                                <span>
                                                  {{project.Nama}}
                                                </span>
                                                <span class="pr-3 right"> 
                                                  <v-chip small :class="` white--text my-2 caption ${project.Status}`">{{project.Status}}</v-chip>
                                                </span>
                                                </v-list-tile-title>
                                            </v-list-tile-content>
                                            <v-list-tile-action style="width:125px; !important">
                                                <v-progress-linear
                                                color="red"
                                                height="20"
                                                :value="project.Contribution"
                                                >
                                                <p class="text-xs-center">{{project.Contribution}}%</p>
                                                </v-progress-linear>
                                            </v-list-tile-action>
                                        </v-list-tile>
                                      </template>
                                      <v-list-group
                                          v-for="(div,index) in project.All_Divisi"
                                          :key="index"
                                          class="pl-2 pr-2"
                                          :value="expandDetail"
                                      >
                                        <template v-slot:activator>
                                          <v-list-tile class="d_div">
                                            <v-list-tile-content style="height:50px">
                                                <v-list-tile-title style="height:35px;line-height:35px">
                                                  <span>
                                                  {{div.Nama}}
                                                </span>
                                                <span class="pr-3 right"> 
                                                  <v-chip small :class="` white--text my-2 caption ${div.Status}`">{{div.Status}}</v-chip>
                                                </span>
                                                </v-list-tile-title>
                                            </v-list-tile-content>
                                            <v-list-tile-action style="min-width:125px; !important">
                                                <v-progress-linear
                                                color="red"
                                                height="20"
                                                :value="div.Contribution"
                                                >
                                                  <p class="text-xs-center">{{div.Contribution}}%</p>
                                                </v-progress-linear>
                                            </v-list-tile-action>
                                          </v-list-tile>
                                        </template>
                                        <v-list-group
                                        v-for="subdiv in project.All_SubDivisi.filter(obj=>obj.Divisi == div.Nama)"
                                        :key="subdiv.Id_Sub_Divisi_Proyek"
                                        class="pl-2 pr-2" 
                                        :value="expandDetail"
                                        >
                                          <template v-slot:activator>
                                            <v-list-tile  class="d_sub_div">
                                              <v-list-tile-content style="height:50px">
                                                <v-list-tile-title style="height:35px;line-height:35px">
                                                  <span>
                                                    {{subdiv.Nama}}
                                                  </span>
                                                  <span class="pr-3 right"> 
                                                    <v-chip small :class="` white--text my-2 caption ${subdiv.Status}`">{{subdiv.Status}}</v-chip>
                                                  </span>
                                                </v-list-tile-title>
                                              </v-list-tile-content>
                                              <v-list-tile-action style="min-width:125px; !important">
                                                  <v-progress-linear
                                                  color="red"
                                                  height="20"
                                                  :value="subdiv.Contribution"
                                                  >
                                                  <p class="text-xs-center">{{subdiv.Contribution}}%</p>
                                                  </v-progress-linear>
                                              </v-list-tile-action>
                                            </v-list-tile>
                                          </template>

                                          <v-list-group
                                          v-for="task in project.All_Task.filter(obj=>obj.Sub_Divisi == subdiv.Nama)"
                                          :key="task.Id_Item_Pekerjaan"
                                          class="pl-2 pr-2"
                                          :value="expandDetail"
                                          >
                                              <template v-slot:activator>
                                                  <v-list-tile  class="d_task">
                                                    <v-list-tile-content style="height:50px">
                                                      <v-list-tile-title style="height:35px;line-height:35px">
                                                        <span>
                                                          {{task.Nama}}
                                                        </span>
                                                        <span class="pr-3 right"> 
                                                          <v-chip small :class="` white--text my-2 caption ${task.Status}`">{{task.Status}}</v-chip>
                                                        </span>
                                                      </v-list-tile-title>
                                                    </v-list-tile-content>
                                                  <v-list-tile-action style="min-width:125px; !important">
                                                      <v-progress-linear  
                                                      color="red"
                                                      height="20"
                                                      :value="task.Contribution"
                                                      >
                                                      <p class="text-xs-center">{{task.Contribution}}%</p>
                                                      </v-progress-linear>
                                                  </v-list-tile-action>
                                                  </v-list-tile>
                                              </template>
                                              <v-list-tile
                                              v-for="subtask in  project.All_SubTask.filter(obj=>obj.Task == task.Nama)"
                                              :key="subtask.Id_Sub_Item_Pekerjaan"
                                              class="d_sub_task ml-2 pr-5 mr-3 ">
                                              <v-list-tile-content>
                                                <v-list-tile-title style="height:35px;line-height:35px;">
                                                  <v-layout row wrap>
                                                    <v-flex xs12 md8>
                                                      <v-tooltip left color="grey darken-4"> 
                                                      <template v-slot:activator="{ on }">
                                                        <div v-on="on" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-size:14px;">{{subtask.Nama}}</div>
                                                      </template>
                                                      <span style="color:white;">{{subtask.Nama}}</span>
                                                    </v-tooltip>
                                                    </v-flex>
                                                    <v-flex xs12 md4>
                                                      <div class="pr-3 right"> 
                                                        <v-chip small :class="` white--text my-2 caption ${subtask.Status}`">{{subtask.Status}}</v-chip>
                                                      </div>
                                                    </v-flex>
                                                  </v-layout>
                                                </v-list-tile-title>
                                              </v-list-tile-content>
                                              <v-list-tile-action style="min-width:125px; !important">
                                                  <v-progress-linear
                                                  color="red"
                                                  height="20"
                                                  :value="subtask.Contribution"
                                                  >
                                                  <p class="text-xs-center">{{subtask.Contribution}}%</p>
                                                  </v-progress-linear>
                                              </v-list-tile-action>
                                            </v-list-tile>
                                          </v-list-group>
                                        </v-list-group>
                                      </v-list-group>
                                    </v-list-group>
                                </v-list>
                            </v-card-text>
                        </v-card>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-tab-item>  
                <v-tab-item>
                  <!-- //ATTENDANCE -->
                </v-tab-item>
              </v-tabs>
            </div>
          </v-container>
        </v-form>
      </v-flex>
      <!-- PROFILE -->
      <v-flex
        xs12
        md4
        class="pr-4"
        v-if="profile"
      >
        <!-- <material-card class="v-card-profile" floating> -->
          <!-- <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="130"
          >
            <img
              src="https://demos.creative-tim.com/vue-material-dashboard/img/marc.aba54d65.jpg"
            > -->
          <!-- </v-avatar> -->
            <v-layout wrap>
              <v-flex
                xs12
                md12
                class="py-0"
              >
              <v-card-text class="text-xs-center py-0">
                <h4 class="card-title font-weight-bold mt-0">{{User.Nama}}</h4>
              </v-card-text>
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.Jabatan"
                  disabled
                />
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.Divisi"
                  disabled
                />
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.Kode"
                  label="Kode"
                  disabled
                >
                </v-text-field>
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.Grade"
                  label="Grade"
                  disabled
                >
                </v-text-field>
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.KTP"
                  label="KTP"
                  disabled
                />
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.Tanggal_Masuk"
                  label="Tanggal Masuk"
                  disabled
                />
              </v-flex>
              <v-flex
                xs12
                md12
                class="py-0"
              >
                <v-textarea
                  clearable
                  clear-icon="cancel"
                  label="Alamat"
                  v-model="User.Alamat"
                  counter
                  rows="3"
                ></v-textarea>
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.Nomor_Asosiasi"
                  label="Assosiation Number"
                  counter
                  disabled
                />
              </v-flex>
              <v-flex
                xs12
                md6
                class="py-0"
              >
                <v-text-field
                  v-model="User.Nomor_SKA"
                  label="SKA Number"
                  counter
                  disabled
                  />
              </v-flex>
            </v-layout>
            <v-card-text class="text-xs-center">
              <v-flex
                xs12
                md12
                class="py-0"
              >
                <v-btn
                  color="info"
                  round
                  class="font-weight-light"
                  @click="updateProfile()"
                >Update Profile
                </v-btn>  
              </v-flex>
              <v-flex
                xs12
                md12
                class="py-0"
              >
                <v-btn
                  color="info"
                  round
                  class="font-weight-light"
                  @click="passwordDialog = true"
                >Change Password
                </v-btn>  
              </v-flex>
            </v-card-text>
        <!-- </material-card> -->
      </v-flex>
    </v-layout>
      
    <!-- Change Password Dialog -->
      <v-layout row justify-center>
          <v-dialog v-model="passwordDialog" persistent max-width="300px" >
          <v-card>
              <v-card-title>
                  <span class="headline">Change Password</span>
              </v-card-title>
              <v-card-text class="text-xs-center" pa-4>
                <v-flex>
                  <v-text-field
                    ref="password"
                    v-model="Old_Password"
                    :rules="[() => !!Old_Password || 'This field is required']"
                    :append-icon="showOPassword ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="showOPassword ? 'text' : 'password'"
                    prepend-icon="mdi-lock"
                    label="Password"
                    placeholder="*********"
                    counter
                    required
                    
                    @click:append="showPassword = !showOPassword"
                  />
                </v-flex>
                <v-flex>
                  <v-text-field
                    ref="New_Password"
                    v-model="New_Password"
                    :rules="[() => !!New_Password || 'This field is required']"
                    :append-icon="showNPassword ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="showNPassword ? 'text' : 'password'"
                    prepend-icon="mdi-lock"
                    label="New Password"
                    placeholder="*********"
                    counter
                    required
                    
                    @click:append="showNPassword = !showNPassword"
                  />
                </v-flex>
                <v-flex>
                  <v-text-field
                    ref="Confirm_Password"
                    v-model="Confirm_Password"
                    :rules="[() => New_Password == Confirm_Password || 'Check your new password']"
                    :append-icon="showCPassword ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="showCPassword ? 'text' : 'password'"
                    prepend-icon="mdi-lock"
                    label="Confirm Password"
                    placeholder="*********"
                    counter
                    required
                    
                    @click:append="showCPassword = !showCPassword"
                  />
                </v-flex>
              </v-card-text>
                
              <v-card-actions>
              <v-spacer/>

              <v-btn color="blue darken-1" flat @click="passwordDialog = false">Close</v-btn>
              <v-btn color="blue darken-1" flat @click="changePassword()">Change Password</v-btn>
              
              </v-card-actions>
          </v-card>
          </v-dialog>
      </v-layout>
      <!-- <v-layout row wrap>
        <v-spacer></v-spacer>
        <v-flex xs12 md1>
          <v-btn
            class="right"
            small
            @click="profile = false" 
            v-if="profile == true"
          >
          Hide 
            <v-icon>
              cancel
            </v-icon>
          </v-btn>
          <v-btn
            class="right"
            small
            @click="profile = true" 
            v-if="profile == false"
          >
          Show 
            <v-icon>
              remove_red_eye
            </v-icon>
          </v-btn>
        </v-flex>
      </v-layout> -->
    <!-- Change Password Dialog -->
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
    //Alerts
    alert:{
        type: null,
        message: null,
        icon: null,
    },
    //Alerts
    //Dialogs
    passwordDialog:false,
    //Dialogs
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
    User : [],
    profile : true,
    New_Password : '',
    Old_Password : '',
    Confirm_Password : '',
    showOPassword: false,
    showNPassword: false,
    showCPassword: false,
    //DATA Projects
    AllProjects : [],
    UserProjects : [],
    LogPengerjaanData:[],
    UserLogs :[],
    Total_Project:0,
    Average_Contribution:0,
    // DUMMY
    // ............
    //TRY
    labels: ['0',],
    values: [0,],
    //EXPAND
    expandDetail:false,
    //SCROLL
    type: 'selector',
    number: 9999,
    selector: '#Productivity',
    selected: 'Button',
    elements: ['Button', 'Radio group'],
    duration: 1000,
    offset: 25,
    easing: 'easeInOutCubic',
    // easings: Object.keys(easings),
  }),
  computed : {
    ...mapGetters({
          id_akun:'LoggedUser/Id_Akun',
          nama: 'LoggedUser/Name',
          akses:'LoggedUser/Akses',
    }),
    target () {
        const val = this[this.type]
        // if (!isNaN(value)) return Number(value)
        // else 
        return val
      },
      options () {
        return {
          duration: this.duration,
          offset: this.offset,
          easing: this.easing,
        }
      },
  },
  mounted () {
    this.loaddata ()
  },
  methods : {
    async loaddata ()
    {
      try {
        this.AllProjects = ((await Controller.getallproject()).data)
        // console.log("PROJECTS")
        // console.log(this.AllProjects)
        // console.log("PROJECTS")
        this.LogPengerjaanData = (await Controller.getalllogpengerjaan()).data.filter(obj=>obj.Progress != 0)
        // console.log("LOG")
        // console.log(this.LogPengerjaanData)
        // console.log("LOG")
        this.User = ((await Controller.getallemployee()).data).filter(obj=>obj.Id_Akun == this.id_akun)[0]
        this.User.Tanggal_Masuk = this.User.Tanggal_Masuk.toString()
        // console.log("USER")
        // console.log(this.User)
        // console.log("USER")
        this.getUserProjects();
      } catch (err) {
        console.log(err)
      }
      
    },
    async getUserProjects()
    {
      try {
        this.UserLogs = this.LogPengerjaanData.filter(obj=>obj.Id_Akun == this.id_akun)
        for(let UserLog of this.UserLogs)
        {
          for(let Project of this.AllProjects)
          {
            if(UserLog.Id_Proyek == Project.Id_Proyek && this.UserProjects.filter(obj=>obj.Id_Proyek == Project.Id_Proyek).length == 0)
            {
              this.getDataFormat(Project)
              this.UserProjects.push(Project)
            }
          }
        }
        this.Total_Project = this.UserProjects.length
        let Total_Contribution = 0
        let value = 0
        for(let UserProject of this.UserProjects)
        {
          Total_Contribution += UserProject.Contribution
          this.labels.push(UserProject.Kode)
          value = (Math.round(UserProject.Contribution * 1000) / 1000).toFixed(3)
          this.values.push(parseFloat(value))
          console.log(value)
        }
        console.log("this.value")
        console.log(this.values)
        
        this.Average_Contribution = Total_Contribution / this.Total_Project
        this.Average_Contribution=(Math.round(this.Average_Contribution * 1000) / 1000).toFixed(3);
        
        console.log("WORKSPACE")
        // console.log(this.LogPengerjaanData)
        console.log(this.UserProjects)
        console.log("WORKSPACE")
      } catch (err) {
         console.log(err)
      }
    },
    getDataFormat(data){
        let alldivisi =[]
        let allsubdivisi=[]
        let alltask=[]
        let allsubtask=[]

        let ProgressProyek = 0
        let ProgressDivisi = 0
        let ProgressSubDivisi = 0
        let ProgressTask = 0
        let ProgressSubTask = 0

        let ContributionProyek = 0
        let ContributionDivisi = 0
        let ContributionSubDivisi = 0
        let ContributionTask = 0
        let MySubTaskContribution = 0
        let OtherSubTaskContribution = 0

        let PersentaseProyek = 0
        let PersentaseDivisi = 0
        let PersentaseSubDivisi = 0
        let PersentaseTask = 0
        let PersentaseSubTask = 0

        let today = new Date().getTime();

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
                            // Id_Item_Pekerjaan       : subtask.Id_Item_Pekerjaan,
                            Projek                  : data.Nama,
                            Divisi                  : div.Nama, 
                            Sub_Divisi              : subdiv.Nama,                     
                            Task                    : task.Nama,                     
                            Nama                    : subtask.Nama,
                            // Kode                    : subtask.Kode,
                            // Deskripsi               : subtask.Deskripsi,
                            Tanggal_Selesai         : subtask.Tanggal_Selesai.split(' ')[0],
                            Persentase              : subtask.Persentase,
                            User                    : '',
                            Remaining               : '',
                            Progress                : '0',
                            Contribution            : '0',
                            Status                  : '',
                            Log_Pengerjaan          :[],
                        }
                        for(let log of this.LogPengerjaanData){
                            if(log.Id_Sub_Item_Pekerjaan == eachsubtask.Id_Sub_Item_Pekerjaan){
                                eachsubtask.Log_Pengerjaan.push(log)
                            }
                        }

                        let logIndexInc = 0
                        let logs = eachsubtask.Log_Pengerjaan.filter(obj=>obj.Berkas!='')
                        for(let log of logs)
                        {
                          if(log.Username == this.nama)
                            MySubTaskContribution += log.Progress
                          else
                            OtherSubTaskContribution += log.Progress
                          // logIndexInc = logs.indexOf(log)+1
                          // // console.log("LOG INDEX")
                          // // console.log(logIndexInc)
                          // // console.log(logs.length)
                          // if(logIndexInc == logs.length-1)
                          // {
                          //   if(log.Username == this.nama)
                          //   {
                          //     // console.log("add my")
                          //     // console.log(log.Progress)
                          //     MySubTaskContribution += log.Progress
                          //   }
                          //   else
                          //   {
                          //     // console.log("add other")
                          //     // console.log(log.Progress)
                          //     OtherSubTaskContribution += log.Progress
                          //   }
                          //   break;
                          // }
                          // if(logs[logIndexInc].Username != log.Username)
                          // {
                          //   if(log.Username == this.nama)
                          //   {
                          //     // console.log("add my")
                          //     // console.log(log.Progress)
                          //     MySubTaskContribution += log.Progress
                          //   }
                          //   else
                          //   {
                          //     // console.log("add other")
                          //     // console.log(log.Progress)
                          //     OtherSubTaskContribution += log.Progress
                          //   }
                          // }
                        }
                        // console.log("Contribution")
                        // console.log(MySubTaskContribution)
                        // console.log(OtherSubTaskContribution)
                        // console.log(MySubTaskContribution-OtherSubTaskContribution)
                        eachsubtask.Contribution = MySubTaskContribution-OtherSubTaskContribution
                        MySubTaskContribution = 0
                        OtherSubTaskContribution = 0
                        ContributionTask += (eachsubtask.Contribution * eachsubtask.Persentase / 100)
                        // console.log(ContributionTask)
                        let target = new Date(eachsubtask.Tanggal_Selesai).getTime();
                        let remaining = parseInt((target-today)/(24*3600*1000));

                        eachsubtask.Remaining = remaining +' days left'

                        if(eachsubtask.Log_Pengerjaan.length > 0){
                            eachsubtask.Log_Pengerjaan = eachsubtask.Log_Pengerjaan.slice().reverse()
                            if(eachsubtask.Log_Pengerjaan.length==1)
                            {
                                eachsubtask.Progress = eachsubtask.Log_Pengerjaan[0].Progress
                                eachsubtask.User = eachsubtask.Log_Pengerjaan[0].Username
                                ProgressTask += (eachsubtask.Progress*eachsubtask.Persentase/100)
                            }
                            else{
                                let data = eachsubtask.Log_Pengerjaan.find(obj=>obj.Berkas!='' )
                                eachsubtask.Progress = data.Progress 
                                eachsubtask.User = data.Username 
                                ProgressTask += (eachsubtask.Progress*eachsubtask.Persentase/100)
                            }
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
                    let target = new Date(task.Tanggal_Selesai).getTime();
                    let remaining = parseInt((target-today)/(24*3600*1000));

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
                        Progress            : ProgressTask,
                        Contribution        : ContributionTask,
                        Remaining           : remaining+' days left'
                    }
                    ContributionTask = 0
                    ProgressTask = 0
                    ContributionSubDivisi += (eachtask.Contribution * eachtask.Persentase / 100 )
                    ProgressSubDivisi += (eachtask.Progress * eachtask.Persentase / 100)
                    if(eachtask.Progress == 100)
                    {
                      eachtask.Status = 'complete'
                      eachtask.Remaining = remaining +' days left'
                    }
                    else
                    {
                      if(remaining >= 0)
                      {
                        eachtask.Status = 'ongoing'
                        eachtask.Remaining = remaining +' days left'
                      }
                      else if (remaining < 0)
                      {
                        eachtask.Status = 'overdue'
                        eachtask.Remaining = remaining +' days overdue'
                      }
                    }
                    alltask.push(eachtask)
                    PersentaseSubDivisi += task.Persentase
                }
                let target = new Date(subdiv.Tanggal_Selesai).getTime();
                let remaining = parseInt((target-today)/(24*3600*1000));

                let eachsubdiv ={
                    Id_Sub_Divisi_Proyek    : subdiv.Id_Sub_Divisi_Proyek,
                    Id_Divisi_Proyek        : subdiv.Id_Divisi_Proyek,
                    Divisi                  : subdiv.Divisi,
                    Nama                    : subdiv.Nama,
                    Tanggal_Selesai         : subdiv.Tanggal_Selesai.split(' ')[0],
                    Persentase              : subdiv.Persentase,
                    Total_Persentase        : PersentaseSubDivisi,
                    Progress                : ProgressSubDivisi,
                    Contribution            : ContributionSubDivisi,
                    Remaining               : remaining+' days left'
                }
                ContributionSubDivisi = 0
                ProgressSubDivisi = 0
                ContributionDivisi += (eachsubdiv.Contribution * eachsubdiv.Persentase / 100 )
                ProgressDivisi += (eachsubdiv.Progress * eachsubdiv.Persentase / 100)
                if(eachsubdiv.Progress == 100)
                {
                  eachsubdiv.Status = 'complete'
                  eachsubdiv.Remaining = remaining +' days left'
                }
                else
                {
                  if(remaining >= 0)
                  {
                    eachsubdiv.Status = 'ongoing'
                    eachsubdiv.Remaining = remaining +' days left'
                  }
                  else if (remaining < 0)
                  {
                    eachsubdiv.Status = 'overdue'
                    eachsubdiv.Remaining = remaining +' days overdue'
                  }
                }
                allsubdivisi.push(eachsubdiv)
                PersentaseSubDivisi = 0
                PersentaseDivisi += subdiv.Persentase
            }
            let target = new Date(div.Tanggal_Selesai).getTime();
            let remaining = parseInt((target-today)/(24*3600*1000));
            let eachdiv ={
                Id_Divisi_Proyek    : div.Id_Divisi_Proyek,
                Id_Divisi_Role      : div.Id_Divisi_Role,
                Id_Proyek           : div.Id_Proyek,
                Nama                : div.Nama,
                Tanggal_Selesai     : div.Tanggal_Selesai.split(' ')[0],
                Persentase          : div.Persentase,
                Total_Persentase    : PersentaseDivisi,
                Progress            : ProgressDivisi,
                Contribution        : ContributionDivisi,
                Remaining           : remaining+' days left'
            }
            ContributionDivisi = 0
            ProgressDivisi = 0
            ContributionProyek += (eachdiv.Contribution * eachdiv.Persentase / 100 ) 
            ProgressProyek += (eachdiv.Progress * eachdiv.Persentase / 100)
            if(eachdiv.Progress == 100)
            {
              eachdiv.Status = 'complete'
              eachdiv.Remaining = remaining +' days left'
            }
            else
            {
              if(remaining >= 0)
              {
                eachdiv.Status = 'ongoing'
                eachdiv.Remaining = remaining +' days left'
              }
              else if (remaining < 0)
              {
                eachdiv.Status = 'overdue'
                eachdiv.Remaining = remaining +' days overdue'
              }
            }
            alldivisi.push(eachdiv)
            PersentaseDivisi = 0
            PersentaseProyek += div.Persentase
        }
        data.Contribution   = ContributionProyek
        ContributionProyek  = 0
        data.Progress       = ProgressProyek
        ProgressProyek      = 0
        let target = new Date(data.Target_Outcome).getTime();
        let remaining = parseInt((target-today)/(24*3600*1000));
        
        if(data.Progress == 100)
        {
          data.Status = 'complete'
          data.Remaining = remaining +' days left'
        }
        else
        {
          if(remaining >= 0)
          {
            data.Status = 'ongoing'
            data.Remaining = remaining +' days left'
          }
          else if (remaining < 0)
          {
            data.Status = 'overdue'
            data.Remaining = remaining +' days overdue'
          }
        }
        
        data.Total_Persentase = PersentaseProyek
        
        data.All_Divisi     = alldivisi
        data.All_SubDivisi  = allsubdivisi
        data.All_Task       = alltask
        data.All_SubTask    = allsubtask
        console.log("DATA")
        console.log(data)
    },
    async updateProfile()
    {
      try{
        console.log(this.User)
        let response = (await Controller.updateemployee(this.User,this.User.Id_Karyawan))
        console.log(response)
        await this.loaddata()
        this.close()
        this.showAlert('success','Sukses Update Karyawan')
      }catch (err) {
        console.log(err)
        this.showAlert('error','Gagal Update Karyawan')
      }
    },
    async changePassword()
    {
      console.log(this.New_Password+this.Confirm_Password)
      try{
        if(this.New_Password ===  this.Confirm_Password)
        {
          this.User.Old_Password = this.Old_Password
          this.User.Password = this.New_Password
          const response = await Controller.updateakun(this.User,this.User.Id_Akun)
          console.log(response)
          if(response != false)
          {
            await this.loaddata()
            this.close()
            this.showAlert('success','Sukses Update Password')
          }
          else
          {
            this.showAlert('error','Password Lama Anda Salah')
          }
          
          
        }
        else
        {
          // this.showAlert('error','Konfirmasi Password Anda Tidak Sesuai')
        }
        
      }catch (err) {
        console.log(err)
        this.showAlert('error','Konfirmasi Password Anda Tidak Sesuai')
      }
    },
    close () {
        this.passwordDialog = false
        this.Old_Password = ''
        this.Confirm_Password = ''
        this.Confirm_Password = ''
        this.showOPassword = false
        this.showNPassword = false
        this.showCPassword = false
      },
    showAlert (type,alert_message) {
      if(type == 'success'){
        this.alert.icon = 'done'
      }
      else if(type == 'error'){
        this.alert.icon = 'clear'
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
  }
}
</script>
<style>
  .v-sheet--offset {
    top: -25px;
    position: relative;
  }

 .d_project{
  border-left: 4px solid #01579B !Important;
  border-color: #01579B !Important;
}
/*.d_div{
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
} */

/* .d_sub_task{
  border-left: 4px solid #004D40 !Important;
  border-color:#004D40 !Important;
} */

/* 
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
} */

</style>









