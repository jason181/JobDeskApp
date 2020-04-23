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
              <v-tab @click="loadProjectData ()">Project</v-tab>
              <v-tab @click="resetEmployeeData(), loadEmployeeData()">Employee</v-tab>
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
                                <div>{{project.Target_Outcome}}</div>
                            </v-flex>   
                            <v-spacer/>
                            <v-flex>
                                <v-btn small @click="openProjectNotesDialog(project)">Notes</v-btn>
                                <!-- <v-btn small>Detail</v-btn> -->
                                <v-btn small v-if="project.deleted_at != null" @click="restoreProject(project)">Restore</v-btn>
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
                                <v-layout row wrap>
                                  <v-flex class="px-1" xs12 sm6 md4 lg2 >
                                    <v-select
                                    v-model="filterDiv"
                                    :items="project_card.All_Divisi"
                                    item-text="Nama"
                                    item-value="Nama"
                                    box
                                    label="Division"
                                    @change="getSubDivision(project)"
                                    ></v-select>
                                  </v-flex>
                                  <v-flex class="px-1" xs12 sm6 md4 lg2 >
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
                                  <v-flex class="px-1" xs12 sm6 md4 lg2 >
                                    <v-select
                                    v-model="filterTask"
                                    :items="task"
                                    item-text="Nama"
                                    item-value="Nama"
                                    box
                                    label="Task"
                                    ></v-select>
                                  </v-flex>
                                  <v-flex class="px-1" xs12 sm6 md4 lg2 >
                                    <v-select
                                    v-model="filterWorkStatus"
                                    :items="work_status"
                                    item-text="Work"
                                    item-value="Value"
                                    box
                                    label="Work Status"
                                    ></v-select>
                                  </v-flex>
                                  <v-flex class="px-1" xs12 sm6 md4 lg2 >
                                    <v-select
                                    v-model="filterTimeStatus"
                                    :items="time_status"
                                    item-text="Time"
                                    item-value="Value"
                                    box
                                    label="Task"
                                    ></v-select>
                                  </v-flex>
                                  <v-flex class="px-1" xs12 sm6 md4 lg2 >
                                    <v-btn  @click="clearFilter()">Clear</v-btn>
                                  </v-flex>
                                </v-layout> 
                            </v-card>   
                            <v-card hover v-ripple class="px-3 scroll-y" v-for="subtask in filteredTask(project_card.All_SubTask)" :key="subtask.Id_Sub_Item_Pekerjaan" flat style="background: #424242 !important;" @click="openTaskDialog(subtask)">
                              <v-layout row wrap :class="`pa-3 project ${subtask.Color}`">
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
                <v-container fluid>
                  <v-layout row wrap v-if="showEmployee==true">
                    <v-flex xs12 sm6 md4 lg3
                    v-for="User of this.Users"
                    :key="User.Username"
                    >
                      <v-card hover width="100%" @click="employeeDetails(User)">
                        <v-avatar tile>
                          <v-sheet color="blue" width="60" height="60" elevation="10">
                            <v-icon dark large>person</v-icon>
                          </v-sheet>
                        </v-avatar>
                        <v-card-title class="right ma-1 font-weight-bold" > 
                          {{User.Username}}
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                          <div>
                            <span class="caption font-weight-light"> <v-icon small>person</v-icon> {{User.Nama}}</span>  
                          </div>
                          <div>
                            <span class="caption font-weight-light"> <v-icon small>work</v-icon> {{User.Divisi}}</span>  
                          </div>
                          <div>
                            <span class="caption font-weight-light"> <v-icon small>spa</v-icon> {{User.Jabatan}}</span>  
                          </div>
                          <v-divider class="my-2" style="margin-left:0px !important;margin-right:0px !important;"></v-divider>
                            <v-icon
                              class="mr-2"
                              small
                            >
                              mdi-clock
                            </v-icon>
                            <span class="caption grey--text font-weight-light">last login {{User.Last_Login}}</span>
                        </v-card-text>
                      </v-card>
                    </v-flex>
                  </v-layout>
                  <!-- EMPLOYEE DETAILS -->
                  <div v-else class="shrink">
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg4 class="justify-center">
                        <v-card width="100%" height="220" max-width="300px">
                          <v-avatar tile>
                            <v-sheet color="blue" width="75" height="75" elevation="10">
                              <v-icon dark large>store</v-icon>
                            </v-sheet>
                          </v-avatar>
                          <v-card-title class="headline right ma-1"> 
                            Project
                          </v-card-title>
                          <div> 
                            <v-divider class="mt-4"></v-divider>
                          </div>
                          <v-card-text class="pa-4 ">
                            <div class="subheading font-weight-light mb-2">Total Project : {{Total_Project}}</div>
                            <div class="subheading font-weight-light mb-3">Average Contribution : {{Average_Contribution}}%</div>
                            <v-divider style="margin:0 !important"></v-divider>
                            <v-btn small class="right" @click="detailContribution = !detailContribution">
                                <span class="caption">Details</span>
                            </v-btn>
                          </v-card-text>
                        </v-card>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg4 class="justify-center">
                        <v-card width="100%" height="220" max-width="300px">
                          <v-avatar tile>
                            <v-sheet color="blue" width="75" height="75" elevation="10">
                            <v-icon dark large>star</v-icon>
                            </v-sheet>
                          </v-avatar>
                          <v-card-title class="headline right ma-1"> 
                            Performance
                          </v-card-title>
                          <div> 
                            <v-divider class="mt-4"></v-divider>
                          </div>
                          <v-card-text class="pa-3" @click="getDetailPerformanceStatus()">
                              <div align="center">
                                <v-rating
                                  v-model="detailPerformanceCard.Rating"
                                  :length="detailPerformanceCard.length"
                                  :empty-icon="detailPerformanceCard.emptyIcon"
                                  :full-icon="detailPerformanceCard.fullIcon"
                                  :half-increments="detailPerformanceCard.halfIncrements"
                                  :hover="detailPerformanceCard.hover"
                                  :readonly="detailPerformanceCard.readonly"
                                  :size="detailPerformanceCard.size"
                                  :dense="detailPerformanceCard.dense"
                                  :color="detailPerformanceCard.color"
                                  :background-color="detailPerformanceCard.bgColor"
                                  
                                ></v-rating>
                                <div class="subheading font-weight-light mb-2">{{detailPerformanceCard.Keterangan}} </div>
                                <!-- <div class="mx-auto my-1" style="font-size:14px">Click The Star</div> -->
                                  <!-- <span class="mx-auto my-2" style="font-size:14px" align="center">Click the Star</span> -->
                              </div>
                              <v-divider style="margin:0 !important"></v-divider>
                              <v-btn small class="right" @click="detailPerformanceDialog = !detailPerformanceDialog">
                                <span class="caption">Details</span>
                            </v-btn>
                          </v-card-text>
                        </v-card>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg4>
                          <v-card width="100%" height="220" max-width="300px">
                          <v-avatar tile>
                              <v-sheet color="blue" width="75" height="75" elevation="10">
                              <v-icon dark large>mdi-account-check</v-icon>
                              </v-sheet>
                          </v-avatar>
                          <v-card-title class="headline right ma-1"> 
                              Attendance
                          </v-card-title>
                          <div> 
                              <v-divider class="mt-4"></v-divider>
                          </div>
                          <v-card-text class="pa-4 ">
                            <div class="subheading font-weight-light mb-2">Total Attendance : 974 Days</div>
                            <div class="subheading font-weight-light mb-3">Average Attendance : 99,5%</div>
                            <v-divider style="margin:0 !important"></v-divider>
                            <v-btn small class="right" @click="detailAttendance = !detailAttendance"> 
                                <span class="caption">Details</span>
                            </v-btn>
                          </v-card-text>
                          </v-card>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                    <!-- PROJECT CONTRIBUTION -->
                    <v-flex xs12 md12 v-if="detailContribution">
                        <v-card color="grey darken-2" height="100%" style="margin:4px;">
                            <v-card-title class="justify-center">
                                <span class="headline">Project Contribution</span>
                            </v-card-title>
                            <v-card-text> 
                                <v-btn small  @click="expandDetail = !expandDetail" slot="activator">
                                    <v-icon small left>filter_list</v-icon>
                                    <span class="caption ">Expand</span>
                                </v-btn>
                                <v-list expand style="height: 100%; min-height:320px;">
                                    <v-list-group
                                    v-for="project in UserProjects"
                                    :key="project.Id_Proyek"
                                    class="px-2"
                                    :value="expandDetail">
                                    <template v-slot:activator>
                                        <v-list-tile>
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
                                                    <v-tooltip left color="grey darken-4" style="left:-260px"> 
                                                    <template v-slot:activator="{ on }">
                                                        <div v-on="on" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-size:14px;">{{subtask.Nama}}</div>
                                                    </template>
                                                    <span style="color:white;">
                                                      {{subtask.Nama}} 
                                                    </span>
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
                                            <div class="ml-1" v-if="subtask.Prestasi_Kerja != 0 && subtask.Contribution>0">
                                              {{subtask.Prestasi_Kerja}} <v-icon small>star</v-icon>
                                            </div>
                                            </v-list-tile>
                                        </v-list-group>
                                        </v-list-group>
                                    </v-list-group>
                                    </v-list-group>
                                </v-list>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <!-- PROJECT CONTRIBUTION -->
                    </v-layout>
                  </div>
                </v-container>
              </v-tab-item>
              <!-- ITEM EMPLOYEE -->
          </v-tabs>
      </v-container>
      <!-- Task Dialog -->
      <v-layout row justify-center>
        <v-dialog v-model="taskDialog" scrollable persistent max-width="600px">
          <v-card>
              <v-card-title>
                <v-layout row wrap> 
                  <v-flex xs12 md8>
                    <span class="headline">{{editTask.Nama}}</span>
                  </v-flex>
                  <v-flex xs12 md4>
                    <span style="vertical-align:center" class="right" v-if="editTask.User!=''">Taken By : {{editTask.User}}</span>
                  </v-flex>
                </v-layout>
<!--                   
                  <v-spacer/> -->
                  
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
                      <v-flex xs12 @click="getPerformanceStatus()">
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
      <!-- Detail Performance Dialog -->
      <v-layout row justify-center>
        <v-dialog v-model="detailPerformanceDialog" scrollable persistent max-width="300px">
          <v-card>
              <v-card-title>
                  <span style="headline">{{ActiveUserData.Username}} PERFORMANCE</span>
                  <v-spacer/>
              </v-card-title>
              <v-divider/>
              <v-card-text>
              <div class="subheading font-weight-light mb-2">Best Performance   : {{UserPerformance.Best_Performance}} / {{UserPerformance.Total_Subtask}}</div>
              <div class="subheading font-weight-light mb-2">Performance        : {{UserPerformance.Performance}} / {{UserPerformance.Total_Subtask}}</div>
              <div class="subheading font-weight-light mb-2">Semi Performance   : {{UserPerformance.Semi_Performance}} / {{UserPerformance.Total_Subtask}}</div>
              <div class="subheading font-weight-light mb-2">Bad Performance    : {{UserPerformance.Bad_Performance}} / {{UserPerformance.Total_Subtask}}</div>
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn color="blue darken-1" flat @click="detailPerformanceDialog = false">Close</v-btn>
              </v-card-actions>
          </v-card>
          </v-dialog>
      </v-layout>
      <!-- Detail Performance Dialog -->
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
// import { try } from 'q';
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
    //**********PROJECTS**********//
    AllProjects:[],
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
    //FILTER
    filterWorkStatus:'',
    filterTimeStatus:'',
    work_status:[
      {
        Work : 'All',
        Value : ''
      },
      { 
        Work : 'Available',
        Value : 'Available'
      },
      { 
        Work : 'On Going',
        Value : 'On Going'
      },
      { 
        Work : 'Complete',
        Value : 'Complete'
      }
    ],
    time_status:[
      {
        Time : 'All',
        Value : ''
      },
      { 
        Time : 'In Time' ,
        Value : 'In Time' 
      },
      { 
        Time : 'On Time' ,
        Value : 'On Time' 
      },
      { 
        Time : 'Overdue', 
        Value : 'Overdue'
      }
    ],
    filter_status:'',
    filterDiv:'',
    division:[],
    filterSubDiv:'',
    sub_division:[],
    filterTask:'',
    task:[],
    //FILTER
    //PERFORMANCE RATING
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
      size: 24,
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
    //PERFORMANCE RATING

    //**********PROJECTS**********//
    
    //**********EMPLOYEE**********//
    Users:[],
    Accounts:[],
    SessionLogs:[],
    expandDetail:false,
    showEmployee:true,
    UserProjects:[],
    ActiveUserData:[],
    //DETAILS
    detailContribution:false,
    detailPerformance:false,
    detailAttendance:false,
    //CONTRIBUTION
    Userlogs:[],
    Total_Project:0,
    Average_Contribution:0,
    //CONTRIBUTION
    //PERFORMANCE
    UserPerformance:{
      Bad_Performance:0,
      Semi_Performance:0,
      Performance:0,
      Best_Performance:0,
      Total_Subtask:0,
    },
    initUserPerformance:{
      Bad_Performance:0,
      Semi_Performance:0,
      Performance:0,
      Best_Performance:0,
      Total_Subtask:0,
    },
    detailPerformanceCard:{
      Nama :'',
      Rating : 0,
      Keterangan: 'Click The Star',
      emptyIcon: 'mdi-star-outline',
      fullIcon: 'mdi-star',
      halfIncrements: false,
      hover: true,
      length: 4,
      readonly: false,
      size: 24,
      dense: false,
      color: 'grey darken-1',
      bgColor: 'grey lighten-1',
    },
    initDetailPerformanceCard:{
      Nama :'',
      Rating : 0,
      Keterangan: 'Click The Star',
      emptyIcon: 'mdi-star-outline',
      fullIcon: 'mdi-star',
      halfIncrements: false,
      hover: true,
      length: 4,
      readonly: false,
      size: 24,
      dense: false,
      color: 'grey darken-1',
      bgColor: 'grey lighten-1',
    },
    detailPerformanceDialog:false,
    //PERFORMANCE
    //ATTENDANCE

    //ATTENDANCE
    //DETAILS


    //**********EMPLOYEE**********//

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
    this.loadProjectData ()
  },
  methods : {
    async loadProjectData ()
    {
      try {
        let data = (await Controller.getallproject())
        this.AllProjects = data
        this.logPengerjaanData = (await Controller.getalllogpengerjaan()).data
        for(let project of data)
        {
          project.isGetProjectDataFormat = false;
        }
        this.projects = data
        this.getItemData(this.projects[0])
      } catch (err) {
        console.log(err)
      }
    },
    async loadEmployeeData()
    {
      try {
        this.showEmployee=true
        if(this.Users.length==0)
        {
          this.Users = (await Controller.getallemployee()).data
          this.Accounts = (await Controller.getallakun()).data
          
          this.SessionLogs = (await Controller.getallsessionlogs()).data
          for(let User of this.Users)
          {
            this.getUserDataFormat(User)
          }
          console.log(this.Users)
        }
      } catch (err) {
        console.log(err)
      }
    },
    //GET DATA
    getUserProjects()
    {
      try {
        // console.log("this.ActiveUserData")
        // console.log(this.ActiveUserData)
        this.UserLogs = this.logPengerjaanData.filter(obj=>obj.Id_Akun == this.ActiveUserData.Id_Akun)
        // console.log("this.UserLogs")
        // console.log(this.UserLogs)
        for(let UserLog of this.UserLogs)
        {
          for(let Project of this.AllProjects)
          {
            if(UserLog.Id_Proyek == Project.Id_Proyek && this.UserProjects.filter(obj=>obj.Id_Proyek == Project.Id_Proyek).length == 0)
            {
              this.getUserProjectDataFormat(Project)
              this.UserProjects.push(Project)
            }
          }
        }
        console.log("this.UserProjects")
        console.log(this.UserProjects)
        this.Total_Project = this.UserProjects.length
        let Total_Contribution = 0
        // let value = 0
        for(let UserProject of this.UserProjects)
        {
          Total_Contribution += UserProject.Contribution
          // this.labels.push(UserProject.Kode)
          // value = (Math.round(UserProject.Contribution * 1000) / 1000).toFixed(3)
          // this.values.push(parseFloat(value))
          // console.log(value)
        }
        // console.log("this.value")
        // console.log(this.values)
        
        this.Average_Contribution = Total_Contribution / this.Total_Project
        this.Average_Contribution=(Math.round(this.Average_Contribution * 1000) / 1000).toFixed(3);
        
        // console.log("WORKSPACE")
        // console.log(this.logPengerjaanData)
        console.log(this.UserProjects)
        // console.log("WORKSPACE")
      } catch (err) {
         console.log(err)
      }
    },
    async getItemData(item)
    {
      this.project_card = []
      if(item.isGetProjectDataFormat == false)
      {
        let index = this.projects.indexOf(item)
        let project = (await Controller.getoneproject(item.Id_Proyek)).data
        this.getDataFormat(project)
        this.projects[index] = Object.assign({}, project)
        this.projects[index]=project
        this.project_card = this.projects[index];
      }
      else
      {
        let index = this.projects.indexOf(item)
        this.project_card = this.projects[index];
      }
    },
    getUserDataFormat(data){
      data.Username = this.Accounts.find(obj=>obj.Id_Akun == data.Id_Akun).Username.toUpperCase()
      for(let SessionLog of this.SessionLogs)
      {
        if(data.Id_Akun == SessionLog.Id_Akun)
        {
          let today = new Date().getTime();
          let last = new Date(SessionLog.Waktu).getTime();
          let difference = parseInt((today-last)/1000);
          if(difference<60)
          {
            data.Last_Login = difference +' seconds ago'
          }
          else if(difference<3600)
          {
            difference = parseInt(difference/60)
            data.Last_Login = difference +' minutes ago'
          }
          else if(difference<86400)
          {
            difference = parseInt(difference/3600)
            data.Last_Login = difference +' hours ago'
          }
          else
          {
            difference = parseInt(difference/86400)
            data.Last_Login = difference +' days ago'
          }
        }
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
                        if(eachsubtask.User == '')
                        {
                          eachsubtask.User = log.Username;
                        }
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
      data.isGetProjectDataFormat = true
    },
    getUserProjectDataFormat(data){
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
                            Prestasi_Kerja          : subtask.Prestasi_Kerja,
                        }
                        for(let log of this.logPengerjaanData){
                            if(log.Id_Sub_Item_Pekerjaan == eachsubtask.Id_Sub_Item_Pekerjaan){
                                eachsubtask.Log_Pengerjaan.push(log)
                            }
                        }

                        let logIndexInc = 0
                        let logs = eachsubtask.Log_Pengerjaan.filter(obj=>obj.Berkas!='')
                        for(let log of logs)
                        {
                          if(log.Nama == this.ActiveUserData.Nama)
                            MySubTaskContribution += log.Progress
                          else
                            OtherSubTaskContribution += log.Progress
                        }
                        // console.log("Contribution")
                        // console.log(MySubTaskContribution)
                        // console.log(OtherSubTaskContribution)
                        // console.log(MySubTaskContribution-OtherSubTaskContribution)
                        eachsubtask.Contribution = MySubTaskContribution
                        // -OtherSubTaskContribution
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
                        // console.log("eachsubtask.User")
                        // console.log(eachsubtask.User)
                        // console.log("this.ActiveUserData.Username")
                        // console.log(this.ActiveUserData.Username)
                        if(eachsubtask.Contribution>0)
                        {
                          if(eachsubtask.Prestasi_Kerja == 1)
                          {
                            console.log("BAD PERFORMANCE")
                            this.UserPerformance.Bad_Performance++
                          }
                          else if(eachsubtask.Prestasi_Kerja == 2)
                          {
                            console.log("SEMI PERFORMANCE")
                            this.UserPerformance.Semi_Performance++
                          }
                          else if(eachsubtask.Prestasi_Kerja == 3)
                          {
                            console.log("PERFORMANCE")
                            this.UserPerformance.Performance++
                          }
                          else if(eachsubtask.Prestasi_Kerja == 4)
                          {
                            console.log("BEST PERFORMANCE")
                            this.UserPerformance.Best_Performance++
                          }
                          if(eachsubtask.Prestasi_Kerja!=0)
                          {
                            this.UserPerformance.Total_Subtask++
                          }
                          console.log("this.UserPerformance dalam")
                          console.log(this.UserPerformance)
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
            this.loadProjectData()
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

    //***********RESTORE DATA***********\\
    async restoreProject(data){
      try {
        let response = await Controller.restoreproject(data.Id_Proyek);
        console.log(response)
      } catch (err) {
        console.log(err)
      }
    },

    //***********RESTORE DATA***********\\

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
    employeeDetails(data){
      this.showEmployee=false
      this.ActiveUserData = data
      this.getUserProjects()
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
    getSubDivision(data)
    {
      this.sub_division = data.All_SubDivisi.filter(obj=>obj.Divisi == this.filterDiv)
      this.filterSubDiv=''
      this.filterTask=''
    },
    getTask(data){
        this.task = data.All_Task.filter(obj=>obj.Sub_Divisi == this.filterSubDiv)
        this.filterTask=''
    },
    filteredTask(data){
      if(this.filterWorkStatus != "")
      {
        data = data.filter(obj=>obj.Work_Status==this.filterWorkStatus)
      }
      if(this.filterTimeStatus !="")
      {
        data = data.filter(obj=>obj.Time_Status==this.filterTimeStatus)
      }
      if(this.filterDiv != "" )
      {
        data = data.filter(obj=>obj.Divisi == this.filterDiv)
      }
      if(this.filterSubDiv != '')
      {
        data = data.filter(obj=>obj.Sub_Divisi == this.filterSubDiv)
      }
      if(this.filterTask != '' )
      {
        data = data.filter(obj=>obj.Task == this.filterTask)
      }
      return data;
    },
    clearFilter(){
        this.filterDiv='';
        this.filterSubDiv='';
        this.filterTask='';
        this.filterWorkStatus='';
        this.filterTimeStatus='';
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
        this.fileName = ''
        this.fileUrl = ''
        
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
    getPerformanceStatus()
    {
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
    getDetailPerformanceStatus()
    {
      console.log("this.UserPerformance")
      console.log(this.UserPerformance)
      if(this.detailPerformanceCard.Rating == 1)
      {
        this.detailPerformanceCard.Keterangan = 'Bad Performance : '+this.UserPerformance.Bad_Performance
        this.detailPerformanceCard.color = 'red'
        this.detailPerformanceCard.bgColor = 'red lighten-1'
      }
      if(this.detailPerformanceCard.Rating == 2)
      {
        this.detailPerformanceCard.Keterangan = 'Semi Performance : '+this.UserPerformance.Semi_Performance
        this.detailPerformanceCard.color = 'yellow'
        this.detailPerformanceCard.bgColor = 'yellow lighten-1'
      }
      if(this.detailPerformanceCard.Rating == 3)
      {
        this.detailPerformanceCard.Keterangan = 'Performance : '+this.UserPerformance.Performance
        this.detailPerformanceCard.color = 'green'
        this.detailPerformanceCard.bgColor = 'green lighten-1'
      }
      if(this.detailPerformanceCard.Rating == 4)
      {
        this.detailPerformanceCard.Keterangan = 'Best Performance : '+this.UserPerformance.Best_Performance
        this.detailPerformanceCard.color = 'blue'
        this.detailPerformanceCard.bgColor = 'blue lighten-1'
      }
    },
    resetEmployeeData(){
      this.Total_Project=0
      this.Average_Contribution=0
      this.UserProjects=[]
      this.ActiveUserData=[]
      this.UserPerformance = Object.assign({}, this.initUserPerformance)
      this.detailPerformanceCard = Object.assign({}, this.initDetailPerformanceCard)
    },
    close () {
        setTimeout(() => {
            this.performanceDialog=false;
            this.taskDialog=false
            this.performance = Object.assign({}, this.initPerformance)
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

.project.yyellow{
  border-left: 4px solid #F9A825  !important;
  border-color:#F9A825  !important;
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
.v-chip.yyellow{
  background: #F9A825  !important;
}

</style>
