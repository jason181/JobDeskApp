<template>
    <div class="jobdesk">
        <v-container>
            <v-layout justify-start class="mb-3">
                <h3 style="border-bottom:white solid 3px;">LIST PROJECT</h3>
            </v-layout>

            <v-layout row class="mb-3">
                <v-btn v-if="this.Id_Akun == 1" small flat color="grey" @click="addDialog2=true" slot="activator">
                    <v-icon small left>create_new_folder</v-icon>
                    <span class="caption ">Add Project</span>
                </v-btn>
            </v-layout>

            <!-- Expand Panel -->
                <v-expansion-panel >
                    <v-expansion-panel-content
                    v-for="project in tempProjects" 
                    :key="project.Nama"
                    expand-icon="mdi-menu-down"
                    @click="clearFilter()"
                    >
                    <template v-slot:header>
                    
                        <v-layout row wrap :class="`pa-3`">
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
                                <v-btn small @click="detailProjectDialog(project)">Detail</v-btn>
                                <v-btn small @click="editProjectDialog(project)">Edit</v-btn>
                            </v-flex>  
                            <!-- <v-flex>
                                <v-btn small @click="editProjectDialog(project)">Edit</v-btn>
                            </v-flex>   -->
                        </v-layout>
                        
                    </template>

                    <v-card class="grey darken-2">
                        <v-container >
                        <v-card>
                            <v-card-title>
                                <span>Filter</span>
                            </v-card-title>
                            <v-layout row>
                            <v-flex class="pl-2" xs12 sm6 md2 >
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
                            <v-flex class="pl-2" xs12 sm6 md2 >
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
                            <v-flex class="pl-2" xs12 sm6 md2 >
                                <v-select
                                v-model="filterTask"
                                :items="task"
                                item-text="Nama"
                                item-value="Nama"
                                box
                                label="Task"
                                ></v-select>
                            </v-flex>
                            <v-flex class="pl-2" xs12 sm6 md2 >
                                <v-btn  @click="clearFilter()">Clear</v-btn>
                            </v-flex>
                            </v-layout> 
                        </v-card>   

                        <v-card hover v-ripple class="scroll-y" v-for="subtask in filteredTask(project.All_SubTask)" :key="subtask.Nama" flat style="background: #424242 !important;" @click="openTaskDialog(subtask)">
                        <v-layout row wrap :class="`pa-3  project ${subtask.Status}`">
                            <v-flex xs12 md4 >
                                <div class="caption grey--text">{{subtask.Divisi}}</div>
                                <div>{{subtask.Sub_Divisi}}</div>
                            </v-flex>
                            <v-flex xs6 sm4 md2>
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
                                    :value="subtask.Progress"
                                    >
                                    <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                    <p class="text-xs-center">{{subtask.Progress}}%</p>
                                    </v-progress-linear>
                                </div>
                            </v-flex>
                            <v-flex xs2 sm4 md2>
                                <!-- <div class="caption grey--text">Status</div> -->
                                <div class="right">
                                    <v-chip small :class="` white--text my-2 caption ${subtask.Status}`">{{subtask.Status}}</v-chip>
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

            <!-- Request Access Dialog -->
                <v-layout row justify-center>
                    <v-dialog v-model="requestDialog" persistent max-width="300px" >
                    <v-card>
                        <v-card-title>
                            <span class="headline">Request Access</span>
                        </v-card-title>
                        <v-card-text>
                            <v-select
                            :items="requestAccess"
                            v-model ="reqForm.Status"
                            item-text="Nama"
                            item-value="Nama"
                            box
                            label="List Access"
                            ></v-select>

                            <v-textarea
                            outline
                            label="Description"
                            v-model="reqForm.Deskripsi"
                            ></v-textarea>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer/>

                        <v-btn color="blue darken-1" flat @click="requestDialog = false">Close</v-btn>
                        <a href="https://api.whatsapp.com/send?phone=62895342148737&text=Asking%20For%20Permission" target="_blank" rel="noopener noreferrer" ><v-btn color="blue darken-1" flat @click="sendAccessRequest()">Send</v-btn></a>
                        
                        <!-- <v-btn color="blue darken-1" v-if="editTask.status=='untake'" flat @click="taskDialog = false">Request</v-btn>
                        <v-btn color="blue darken-1" v-else flat @click="taskDialog = false">Save</v-btn> -->

                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-layout>
            <!-- Request Access Dialog -->

            <!-- Add Dialog 2 -->
                <v-layout row justify-center>
                    <v-dialog v-model="addDialog2" persistent fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar>
                            <v-btn icon dark @click="close()">
                                <v-icon>close</v-icon>
                            </v-btn>
                            <v-toolbar-title class="white--text">Add Project</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn dark flat v-if="editmode == false" @click="addProjectAll()">Add</v-btn>
                                <v-btn dark flat v-else-if="editmode == true" @click="updateProjectAll()">Save</v-btn>

                                
                            </v-toolbar-items>
                        </v-toolbar>

                        <v-container fluid>
                            <v-layout row wrap>
                                <!-- Form  -->
                                <v-flex xs12 sm12 md8 >
                                    <v-card color="grey darken-2" height="100%" style="margin:4px;">
                                        <v-card-title class="justify-center">
                                            <span class="headline">Project Form</span>
                                        </v-card-title>
                                        <v-card-text> 
                                            
                                            <v-stepper v-model="e1">
                                                <v-stepper-header>
                                                    <v-stepper-step
                                                    complete
                                                    editable
                                                    step="1"
                                                    >
                                                    <!-- Project Information -->
                                                    PI
                                                    </v-stepper-step>

                                                    <v-divider></v-divider>

                                                    <v-stepper-step
                                                    complete
                                                    editable
                                                    step="2"
                                                    >
                                                    <!-- Division -->
                                                    D
                                                    </v-stepper-step>

                                                    <v-divider></v-divider>

                                                    <v-stepper-step
                                                    complete
                                                    editable
                                                    step="3"
                                                    >
                                                    <!-- Sub Divison -->
                                                    SD
                                                    </v-stepper-step>

                                                    <v-divider></v-divider>

                                                    <v-stepper-step
                                                    complete
                                                    editable
                                                    step="4"
                                                    >
                                                    <!-- Task -->
                                                    T
                                                    </v-stepper-step>

                                                    <v-divider></v-divider>

                                                    <v-stepper-step
                                                    complete
                                                    editable
                                                    step="5"
                                                    >
                                                    <!-- Sub Task -->
                                                    ST
                                                    </v-stepper-step>
                                                </v-stepper-header>

                                                <v-stepper-items>

                                                <v-stepper-content step="1">
                                                    <v-card height="100%">
                                                        <v-card-title class="justify-center">
                                                            <span class="headline">Project Information</span>
                                                        </v-card-title>
                                                        <v-card-text> 
                                                            <v-container>
                                                                <v-layout row wrap>
                                                                    <v-flex xs4>
                                                                        <v-text-field 
                                                                        box
                                                                        v-model="editProject.Kode" 
                                                                        label="Code" 
                                                                        prepend-icon="contact_support"
                                                                        height=2
                                                                        ></v-text-field>
                                                                    </v-flex>         
                                                                    <v-flex xs8 class="pr-2">
                                                                        <v-text-field 
                                                                        box
                                                                        v-model="editProject.Nama" 
                                                                        label="Project Name" 
                                                                        prepend-icon="contact_support"
                                                                        height=2
                                                                        ></v-text-field>
                                                                    </v-flex>          
                                                                    <v-flex xs12 md6 class="pr-2">
                                                                        <v-text-field 
                                                                        box
                                                                        v-model="editProject.Nilai" 
                                                                        label="Value" 
                                                                        prepend-icon="contact_support"
                                                                        ></v-text-field>
                                                                    </v-flex>
                                                                    <v-flex xs12 md6>
                                                                        <v-text-field 
                                                                        box
                                                                        v-model="editProject.Target_Outcome" 
                                                                        label="Target Outcome" 
                                                                        prepend-icon="contact_support"
                                                                        ></v-text-field>
                                                                    </v-flex>

                                                                    <v-flex xs12 md4 class="pr-2">
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
                                                                            v-model="editProject.Tanggal_Mulai"
                                                                            label="Start Date"
                                                                            prepend-icon="event"
                                                                            box
                                                                            v-on="on"
                                                                            readonly
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker  v-model="editProject.Tanggal_Mulai" @input="startDate = false"></v-date-picker>
                                                                        </v-menu>
                                                                    </v-flex>
                                                                    <v-flex xs12 md4 class="pr-2">
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
                                                                            v-model="editProject.Tanggal_Selesai"
                                                                            label="Finish Date"
                                                                            prepend-icon="event"
                                                                            box
                                                                            v-on="on"
                                                                            readonly
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker  v-model="editProject.Tanggal_Selesai" @input="finishDate = false"></v-date-picker>
                                                                        </v-menu>
                                                                    </v-flex>
                                                                    <v-flex xs12 md4 >
                                                                        <v-text-field 
                                                                        box
                                                                        v-model="editProject.Pemilik" 
                                                                        label="Owner" 
                                                                        prepend-icon="contact_support"
                                                                        ></v-text-field>
                                                                    </v-flex>
                                                                    <v-flex xs12 md8 class="pr-2">
                                                                        <v-textarea    
                                                                        box                                     
                                                                        label="Note"
                                                                        v-model="editProject.Catatan"
                                                                        prepend-icon="contact_support"

                                                                        ></v-textarea>
                                                                    </v-flex>    
                                                                    <v-flex xs12 md4 >
                                                                        <v-textarea    
                                                                        box                                     
                                                                        label="Address"
                                                                        v-model="editProject.Alamat"
                                                                        prepend-icon="contact_support"

                                                                        ></v-textarea>
                                                                    </v-flex>                                                
                                                                </v-layout>
                                                            
                                                            </v-container>
                                                        </v-card-text>
                                                    </v-card>

                                                    <v-btn
                                                    color="primary"
                                                    @click="e1 = 2"
                                                    >
                                                    Next
                                                    </v-btn>

                                                    <v-btn flat>Cancel</v-btn>
                                                </v-stepper-content>

                                                <v-stepper-content step="2">
                                                    <v-card
                                                    height="100%"
                                                    >
                                                        <v-card-title class="justify-center">
                                                            <span class="headline">Division</span>
                                                        </v-card-title>
                                                        <v-card-text>
                                                            <v-container>
                                                                <v-toolbar flat  color="grey darken-3">
                                                                    <v-select
                                                                    :items="division"
                                                                    v-model ="divform.Id_Divisi_Role"
                                                                    item-text="Deskripsi"
                                                                    item-value="Id_Divisi_Role"
                                                                    box
                                                                    label="Divisi"
                                                                    ></v-select>
                                                                    <!-- <v-text-field 
                                                                        v-model="divform.Nama"
                                                                        label="Name"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field> -->
                                                                    <v-text-field
                                                                        v-model="divform.Persentase"
                                                                        label="Contribute"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-menu
                                                                    v-model="dateDiv1"
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
                                                                        v-model="divform.Tanggal_Selesai"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                        v-on="on"
                                                                        readonly
                                                                        ></v-text-field>
                                                                    </template>
                                                                    <v-date-picker  v-model="divform.Tanggal_Selesai" @input="dateDiv1 = false"></v-date-picker>
                                                                    </v-menu>
                                                                    <!-- <v-text-field
                                                                        v-model="divform.Tanggal_Selesai"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field> -->
                                                                    <!-- <v-toolbar-title>My CRUD</v-toolbar-title> -->
                                                                    <v-divider
                                                                        class="mx-2"
                                                                        inset
                                                                        vertical
                                                                    ></v-divider>
                                                                    <v-btn @click="addDivForm()">Add</v-btn>
                                                                </v-toolbar>

                                                                <v-data-table
                                                                :headers="div_headers"
                                                                :items="editProject.All_Divisi"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Nama"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                        
                                                                        
                                                                    > {{ props.item.Nama }}
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Nama"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Persentase"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.Persentase }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Persentase"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Tanggal_Selesai"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.Tanggal_Selesai }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field> -->
                                                                        <v-menu
                                                                        v-model="dateDiv2"
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
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Target Date"
                                                                            box
                                                                            class="mx-1"
                                                                            v-on="on"
                                                                            readonly
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker  v-model="props.item.Tanggal_Selesai" @input="dateDiv2 = false"></v-date-picker>
                                                                        </v-menu>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                        <v-icon
                                                                            small
                                                                            @click="delDivForm(props.item)"
                                                                        >
                                                                            delete
                                                                        </v-icon>
                                                                    </td>

                                                                    <!-- <td class="text-xs-right">{{ props.item.due_date }}</td> -->

                                                                </template>
                                                                </v-data-table>
                                                            </v-container>
                                                        </v-card-text>
                                                    </v-card>

                                                    <v-btn
                                                    color="primary"
                                                    @click="e1 = 3"
                                                    >
                                                    Next
                                                    </v-btn>

                                                    <v-btn flat>Cancel</v-btn>
                                                </v-stepper-content>

                                                <v-stepper-content step="3">
                                                    <v-card
                                                    height="100%"
                                                    >
                                                        <v-card-title class="justify-center">
                                                            <span class="headline">Sub Division</span>
                                                        </v-card-title>
                                                        <v-card-text>
                                                            <v-container>
                                                                <v-toolbar flat  color="grey darken-3">
                                                                    <v-select
                                                                    :items="editProject.All_Divisi"
                                                                    v-model ="subdivform.Divisi"
                                                                    item-text="Nama"
                                                                    item-value="Nama"
                                                                    box
                                                                    label="Divisi"
                                                                    ></v-select>
                                                                    <v-text-field 
                                                                        v-model="subdivform.Nama"
                                                                        label="Name"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="subdivform.Persentase"
                                                                        label="Contribute"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <!-- <v-text-field
                                                                        v-model="subdivform.Tanggal_Selesai"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field> -->
                                                                    <v-menu
                                                                    v-model="dateSubDiv1"
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
                                                                        v-model="subdivform.Tanggal_Selesai"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                        v-on="on"
                                                                        readonly
                                                                        ></v-text-field>
                                                                    </template>
                                                                    <v-date-picker  v-model="subdivform.Tanggal_Selesai" @input="dateSubDiv1 = false"></v-date-picker>
                                                                    </v-menu>
                                                                    <!-- <v-toolbar-title>My CRUD</v-toolbar-title> -->
                                                                    <v-divider
                                                                        class="mx-2"
                                                                        inset
                                                                        vertical
                                                                    ></v-divider>
                                                                    <v-btn @click="addSubDivForm()">Add</v-btn>
                                                                </v-toolbar>

                                                                <v-data-table
                                                                :headers="subdiv_headers"
                                                                :items="editProject.All_SubDivisi"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Divisi"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                        
                                                                        
                                                                    > <div>{{ props.item.Divisi }}</div>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field> -->
                                                                        <v-select
                                                                        :items="editProject.All_Divisi"
                                                                        v-model ="props.item.Divisi"
                                                                        item-text="Nama"
                                                                        item-value="Nama"
                                                                        box
                                                                        label="Divisi"
                                                                        ></v-select>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Nama"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                        
                                                                        
                                                                    > <div>{{ props.item.Nama }}</div>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Nama"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Persentase"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.Persentase }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Persentase"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Tanggal_Selesai"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.Tanggal_Selesai }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field> -->
                                                                        <v-menu
                                                                        v-model="dateSubDiv2"
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
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Target Date"
                                                                            box
                                                                            class="mx-1"
                                                                            v-on="on"
                                                                            readonly
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker  v-model="props.item.Tanggal_Selesai" @input="dateSubDiv2 = false"></v-date-picker>
                                                                        </v-menu>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                        <v-icon
                                                                            small
                                                                            @click="delSubDivForm(props.item)"
                                                                        >
                                                                            delete
                                                                        </v-icon>
                                                                    </td>

                                                                    <!-- <td class="text-xs-right">{{ props.item.due_date }}</td> -->

                                                                </template>
                                                                </v-data-table>
                                                            </v-container>
                                                        </v-card-text>
                                                    </v-card>

                                                    <v-btn
                                                    color="primary"
                                                    @click="e1 = 4"
                                                    >
                                                    Continue
                                                    </v-btn>

                                                    <v-btn flat>Cancel</v-btn>
                                                </v-stepper-content>

                                                <v-stepper-content step="4">
                                                    <v-card
                                                    height="100%"
                                                    >
                                                        <v-card-title class="justify-center">
                                                            <span class="headline">Task</span>
                                                        </v-card-title>
                                                        <v-card-text>
                                                            <v-container>
                                                                <v-toolbar flat  color="grey darken-3">
                                                                    <v-select
                                                                    :items="editProject.All_SubDivisi"
                                                                    v-model ="taskform.Sub_Divisi"
                                                                    item-text="Nama"
                                                                    item-value="Nama"
                                                                    box
                                                                    label="Sub Divisi"
                                                                    ></v-select>
                                                                    <v-text-field 
                                                                        v-model="taskform.Nama"
                                                                        label="Name"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="taskform.Persentase"
                                                                        label="Contribute"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <!-- <v-text-field
                                                                        v-model="taskform.Tanggal_Selesai"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field> -->
                                                                    <v-menu
                                                                    v-model="dateTask1"
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
                                                                        v-model="taskform.Tanggal_Selesai"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                        v-on="on"
                                                                        readonly
                                                                        ></v-text-field>
                                                                    </template>
                                                                    <v-date-picker  v-model="taskform.Tanggal_Selesai" @input="dateTask1 = false"></v-date-picker>
                                                                    </v-menu>
                                                                    <!-- <v-toolbar-title>My CRUD</v-toolbar-title> -->
                                                                    <v-divider
                                                                        class="mx-2"
                                                                        inset
                                                                        vertical
                                                                    ></v-divider>
                                                                    <v-btn @click="addTaskForm()">Add</v-btn>
                                                                </v-toolbar>

                                                                <v-data-table
                                                                :headers="task_headers"
                                                                :items="editProject.All_Task"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Sub_Divisi"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                        
                                                                        
                                                                    > <div>{{ props.item.Sub_Divisi }}</div>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field> -->
                                                                        <v-select
                                                                        :items="editProject.ad_Sub_Divisi"
                                                                        v-model ="props.item.Sub_Divisi"
                                                                        item-text="Nama"
                                                                        item-value="Nama"
                                                                        box
                                                                        label="Sub Divisi"
                                                                        ></v-select>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Nama"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                        
                                                                        
                                                                    > <div>{{ props.item.Nama }}</div>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Nama"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Persentase"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.Persentase }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Persentase"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Tanggal_Selesai"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.Tanggal_Selesai }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field> -->
                                                                        <v-menu
                                                                        v-model="dateTask2"
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
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Target Date"
                                                                            box
                                                                            class="mx-1"
                                                                            v-on="on"
                                                                            readonly
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker  v-model="props.item.Tanggal_Selesai" @input="dateTask2 = false"></v-date-picker>
                                                                        </v-menu>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                        <v-icon
                                                                            small
                                                                            @click="delTaskForm(props.item)"
                                                                        >
                                                                            delete
                                                                        </v-icon>
                                                                    </td>

                                                                    <!-- <td class="text-xs-right">{{ props.item.due_date }}</td> -->

                                                                </template>
                                                                </v-data-table>
                                                            </v-container>
                                                        </v-card-text>
                                                    </v-card>

                                                    <v-btn
                                                    color="primary"
                                                    @click="e1 = 5"
                                                    >
                                                    Continue
                                                    </v-btn>

                                                    <v-btn flat>Cancel</v-btn>
                                                </v-stepper-content>

                                                <v-stepper-content step="5">
                                                    <v-card
                                                    height="100%"
                                                    >
                                                        <v-card-title class="justify-center">
                                                            <span class="headline">Sub Task</span>
                                                        </v-card-title>
                                                        <v-card-text class="pt-0">
                                                            <v-container class="pt-0">
                                                                <v-toolbar flat  dense color="grey darken-3">
                                                                    <v-layout row>
                                                                        <v-flex xs3>
                                                                            <v-select
                                                                            :items="editProject.All_Task"
                                                                            v-model ="subtaskform.Task"
                                                                            item-text="Nama"
                                                                            item-value="Nama"
                                                                            box
                                                                            label="Task"
                                                                            ></v-select>
                                                                        </v-flex>
                                                                         <v-flex xs3>
                                                                            <v-text-field 
                                                                                v-model="subtaskform.Nama"
                                                                                label="Name"
                                                                                box
                                                                                class="mx-1"
                                                                            ></v-text-field>
                                                                         </v-flex>
                                                                         <v-flex xs3>
                                                                            <v-text-field
                                                                                v-model="subtaskform.Persentase"
                                                                                label="Contribute"
                                                                                box
                                                                                class="mx-1"
                                                                            ></v-text-field>
                                                                         </v-flex>
                                                                         <v-flex xs3>
                                                                            <v-menu
                                                                            v-model="dateSubTask1"
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
                                                                                v-model="subtaskform.Tanggal_Selesai"
                                                                                label="Target Date"
                                                                                box
                                                                                class="mx-1"
                                                                                v-on="on"
                                                                                readonly
                                                                                ></v-text-field>
                                                                            </template>
                                                                            <v-date-picker  v-model="subtaskform.Tanggal_Selesai" @input="dateSubTask1 = false"></v-date-picker>
                                                                            </v-menu>
                                                                         </v-flex>
                                                                         


                                                                    </v-layout>
                                                                    
                                                                   
                                                                   
                                                                    
                                                                    <!-- <v-text-field
                                                                        v-model="subtaskform.Tanggal_Selesai"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field> -->
                                                                    
                                                                    <!-- <v-toolbar-title>My CRUD</v-toolbar-title> -->
                                                                      <!-- <v-spacer></v-spacer>    -->
                                                                    
                                                                </v-toolbar>
                                                                <v-container class="pt-0">
                                                                    <v-layout row>
                                                                            <v-flex xs6>
                                                                                <v-textarea
                                                                                    outline
                                                                                    label="Description"
                                                                                    v-model="subtaskform.Deskripsi"
                                                                                ></v-textarea>
                                                                                
                                                                            </v-flex>
                                                                            
                                                                            <v-divider
                                                                                class="mx-2"
                                                                                inset
                                                                                vertical
                                                                            ></v-divider>
                                                                            
                                                                            <v-flex xs2>
                                                                                
                                                                                <v-btn @click="addSubTaskForm()">Add</v-btn>
                                                                            </v-flex>
                                                                            
                                                                    </v-layout>
                                                                </v-container>

                                                                <v-data-table
                                                                :headers="subtask_headers"
                                                                :items="editProject.All_SubTask"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Task"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                        
                                                                        
                                                                    > <div>{{ props.item.Task }}</div>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field> -->
                                                                        <v-select
                                                                        :items="editProject.All_Task"
                                                                        v-model ="props.item.Task"
                                                                        item-text="nama"
                                                                        item-value="nama"
                                                                        box
                                                                        label="Task"
                                                                        ></v-select>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Nama"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                        
                                                                        
                                                                    > <div>{{ props.item.Nama }}</div>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Nama"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Persentase"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.Persentase }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.Persentase"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Tanggal_Selesai"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.Tanggal_Selesai }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field> -->
                                                                        <v-menu
                                                                        v-model="dateSubtask2"
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
                                                                            v-model="props.item.Tanggal_Selesai"
                                                                            label="Target Date"
                                                                            box
                                                                            class="mx-1"
                                                                            v-on="on"
                                                                            readonly
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker  v-model="props.item.Tanggal_Selesai" @input="dateSubtask2 = false"></v-date-picker>
                                                                        </v-menu>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.Deskripsi"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <!-- <div>{{ props.item.Deskripsi }}</div> -->
                                                                        <div>
                                                                            <v-icon color="grey lighten-1"
                                                                            small
                                                                            >
                                                                            message

                                                                            </v-icon>
                                                                             Click to Detail
                                                                        </div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Description</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                            <v-textarea
                                                                                outline
                                                                                v-model="props.item.Deskripsi"
                                                                                label="Edit"
                                                                                style="min-width:350px;"
                                                                            ></v-textarea>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.Deskripsi"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field> -->
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                        <v-icon
                                                                            small
                                                                            @click="delSubTaskForm(props.item)"
                                                                        >
                                                                            delete
                                                                        </v-icon>
                                                                    </td>

                                                                    <!-- <td class="text-xs-right">{{ props.item.due_date }}</td> -->

                                                                </template>
                                                                </v-data-table>
                                                            </v-container>
                                                        </v-card-text>
                                                    </v-card>
                                                    <v-btn
                                                    color="primary"
                                                    @click="e1 = 5"
                                                    >
                                                    Continue
                                                    </v-btn>

                                                    <v-btn flat>Cancel</v-btn>
                                                </v-stepper-content>
                                                
                                                </v-stepper-items>
                                            </v-stepper>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <!-- Form  -->

                                <!-- Struct  -->
                                <v-flex xs12 sm12 md4  >
                                    <v-layout row wrap >
                                        <v-flex xs12 sm12 md12>
                                            <v-card color="grey darken-2"  style="margin:4px;">
                                                <v-card-title class="justify-center">
                                                    <span class="headline">Project Template</span>
                                                </v-card-title>
                                                <v-card-text> 
                                                    <v-layout row wrap>
                                                        <v-flex xs12 sm8 md8>
                                                            <v-select 
                                                            :items="tempProjects"
                                                            v-model ="templateProject"
                                                            item-text="Nama"
                                                            item-value="Id_Proyek"
                                                            box
                                                            label="Current Project"
                                                            prepend-icon="contact_support"
                                                            ></v-select>
                                                        </v-flex>
                                                        <v-flex xs12 sm4 md4 class="pl-2">
                                                            <v-btn @click="loadTemplate()">Load</v-btn>
                                                        </v-flex>
                                                    </v-layout>
                                                    
                                                </v-card-text>

                                            </v-card>
                                        </v-flex>
                                        <v-flex xs12 sm12 md12>
                                            <v-card color="grey darken-2" height="100%"  style="margin:4px;">
                                                <v-card-title class="justify-center">
                                                    <span class="headline">Project Structure</span>
                                                </v-card-title>
                                                <v-card-text> 
                                                    <v-btn small  @click="expandDetail = !expandDetail" slot="activator">
                                                        <v-icon small left>filter_list</v-icon>
                                                        <span class="caption ">Expand</span>
                                                    </v-btn>
                                                    <v-list expand style="height: 300px; overflow-y: auto;">
                                                        <v-list-group
                                                        value="true">

                                                        <template v-slot:activator>
                                                            <v-list-tile>
                                                            <v-list-tile-content>
                                                                <v-list-tile-title>
                                                                <span>{{editProject.Nama}}</span>
                                                                
                                                                <!-- <v-btn small color="info">Detail</v-btn> -->
                                                                </v-list-tile-title>
                                                            </v-list-tile-content>
                                                            
                                                            </v-list-tile>
                                                        </template>
                                            
                                                            <v-list-group
                                                                v-for="(div,index) in editProject.All_Divisi"
                                                                :key="index"
                                                                class="pl-2 pr-2"
                                                                :value="expandDetail"
                                                                
                                                            >
                                                                <template v-slot:activator>
                                                                    <v-list-tile class="d_div">
                                                                    <v-list-tile-content>
                                                                        <v-list-tile-title>{{ div.Nama }}
                                                                            <!-- <span class="pl-5"> 2 days remaining</span> -->
                                                                        </v-list-tile-title>
                                                                    </v-list-tile-content>
                                                                    
                                                                    </v-list-tile>
                                                                </template>

                                                                <v-list-group
                                                                v-for="(subdiv,index) in editProject.All_SubDivisi.filter(obj => obj.Divisi == div.Nama)"
                                                                :key="index"
                                                                class="pl-2 pr-2" 
                                                                :value="expandDetail"
                                                                >
                                                                    <template v-slot:activator>
                                                                        <v-list-tile  class="d_sub_div">
                                                                        <v-list-tile-content >
                                                                            <v-list-tile-title>{{ subdiv.Nama }}
                                                                                <!-- <span class="pl-5"> 2 days remaining</span> -->
                                                                            </v-list-tile-title>
                                                                        </v-list-tile-content>
                                                                        
                                                                        </v-list-tile>
                                                                    </template>

                                                                    <v-list-group
                                                                    v-for="(task,index) in editProject.All_Task.filter(obj => obj.Sub_Divisi == subdiv.Nama)"
                                                                    :key="index"
                                                                    class="pl-2 pr-2"
                                                                    :value="expandDetail"
                                                                    >
                                                                        <template v-slot:activator>
                                                                            <v-list-tile  class="d_task">
                                                                            <v-list-tile-content>
                                                                                <v-list-tile-title>{{ task.Nama }}
                                                                                    <!-- <span class="pl-5"> 2 days remaining</span> -->
                                                                                </v-list-tile-title>
                                                                            </v-list-tile-content>
                                                                            
                                                                            </v-list-tile>
                                                                        </template>
                                                                        <v-list-tile
                                                                        v-for="(subtask,index) in editProject.All_SubTask.filter(obj => obj.Task == task.Nama)"
                                                                        :key="index"
                                                                        class="d_sub_task pl-2 pr-5 mr-3 ">
                                                                        <v-list-tile-content>
                                                                            <v-list-tile-title>{{ subtask.Nama }}
                                                                                <!-- <span class="pl-5"> 2 days remaining</span> -->
                                                                            </v-list-tile-title>
                                                                        </v-list-tile-content>
                                                                        
                                                                        </v-list-tile>
                                                                    
                            
                                                                    
                                                                    </v-list-group>

                        
                                                                    
                                                                </v-list-group>
                                                            
                                                
                                                                <!-- <v-list-tile-action>
                                                                <v-icon>{{ div.action }}</v-icon>
                                                                </v-list-tile-action> -->
                                                            </v-list-group>
                                                        </v-list-group>
                                                    </v-list>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                        
                                    </v-layout>
                                </v-flex>
                                <!-- Struct  -->

                            </v-layout>
                        </v-container>
                    </v-card>
                    </v-dialog>
                </v-layout>
            <!-- Add Dialog 2 -->

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

            <!-- Detail Dialog -->
                <v-layout row justify-center>
                    <v-dialog v-model="detailDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar>
                            <v-btn icon dark @click="detailDialog = !detailDialog">
                                <v-icon>close</v-icon>
                            </v-btn>
                            <v-toolbar-title class="white--text">Detail Project</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <!-- <v-toolbar-items>
                                <v-btn dark flat @click="detailDialog = !detailDialog">Save</v-btn>
                            </v-toolbar-items> -->
                        </v-toolbar>

                        <v-container fluid>
                            <v-layout row wrap>
                                <v-flex xs12 md6  >
                                    <v-card color="grey darken-2" height="100%" style="margin:4px;">
                                        <v-card-title class="justify-center">
                                            <span class="headline">Project Progress</span>
                                        </v-card-title>
                                        <v-card-text> 
                                            <v-btn small  @click="expandDetail = !expandDetail" slot="activator">
                                                <v-icon small left>filter_list</v-icon>
                                                <span class="caption ">Expand</span>
                                            </v-btn>
                                            <v-list expand style="height: 300px; overflow-y: auto;">
                                                <v-list-group
                                                value="true">

                                                <template v-slot:activator>
                                                    <v-list-tile>
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>
                                                        <span>{{detailProject.Nama}}</span>
                                                        
                                                        <span class="pl-5"> {{detailProject.Remaining}}</span>

                                                        <!-- <v-btn small color="info">Detail</v-btn> -->
                                                        </v-list-tile-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action style="min-width:150px; !important">
                                                            <v-progress-linear
                                                        color="red"
                                                        height="20"
                                                        :value="detailProject.Progress"
                                                        >
                                                        <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                                        <p class="text-xs-center">{{detailProject.Progress}}%</p>
                                                        </v-progress-linear>
                                                    </v-list-tile-action>
                                                    </v-list-tile>
                                                </template>
                                    
                                                    <v-list-group
                                                        v-for="div in detailProject.All_Divisi"
                                                        :key="div.Id_Divisi_Proyek"
                                                        class="pl-2 pr-2"
                                                        :value="expandDetail"
                                                        
                                                    >
                                                        <template v-slot:activator>
                                                            <v-list-tile class="d_div">
                                                            <v-list-tile-content>
                                                                <v-list-tile-title>{{ div.Nama }}
                                                                    <span class="pl-5"> {{div.Remaining}}</span>
                                                                </v-list-tile-title>
                                                            </v-list-tile-content>
                                                            <v-list-tile-action style="min-width:150px; !important">
                                                                <v-progress-linear
                                                                color="red"
                                                                height="20"
                                                                :value="div.Progress"
                                                                >
                                                                <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                                                <p class="text-xs-center">{{div.Progress}}%</p>
                                                                </v-progress-linear>
                                                            </v-list-tile-action>
                                                            </v-list-tile>
                                                        </template>

                                                        <v-list-group
                                                        v-for="subdiv in detailProject.All_SubDivisi.filter(obj=>obj.Divisi == div.Nama)"
                                                        :key="subdiv.Id_Sub_Divisi_Proyek"
                                                        class="pl-2 pr-2" 
                                                        :value="expandDetail"
                                                        >
                                                            <template v-slot:activator>
                                                                <v-list-tile  class="d_sub_div">
                                                                <v-list-tile-content >
                                                                    <v-list-tile-title>{{ subdiv.Nama }}
                                                                        <span class="pl-5"> {{subdiv.Remaining}}</span>
                                                                    </v-list-tile-title>
                                                                </v-list-tile-content>
                                                                <v-list-tile-action style="min-width:150px; !important">
                                                                    <v-progress-linear
                                                                    color="red"
                                                                    height="20"
                                                                    :value="subdiv.Progress"
                                                                    >
                                                                    <p class="text-xs-center">{{subdiv.Progress}}%</p>
                                                                    </v-progress-linear>
                                                                </v-list-tile-action>
                                                                </v-list-tile>
                                                            </template>

                                                            <v-list-group
                                                            v-for="task in detailProject.All_Task.filter(obj=>obj.Sub_Divisi == subdiv.Nama)"
                                                            :key="task.Id_Item_Pekerjaan"
                                                            class="pl-2 pr-2"
                                                            :value="expandDetail"
                                                            >
                                                                <template v-slot:activator>
                                                                    <v-list-tile  class="d_task">
                                                                    <v-list-tile-content>
                                                                        <v-list-tile-title>{{ task.Nama }}
                                                                            <span class="pl-5"> {{task.Remaining}}</span>
                                                                        </v-list-tile-title>
                                                                    </v-list-tile-content>
                                                                    <v-list-tile-action style="min-width:150px; !important">
                                                                        <v-progress-linear
                                                                        color="red"
                                                                        height="20"
                                                                        :value="task.Progress"
                                                                        >
                                                                        <p class="text-xs-center">{{task.Progress}}%</p>
                                                                        </v-progress-linear>
                                                                    </v-list-tile-action>
                                                                    </v-list-tile>
                                                                </template>

                                                                <v-list-tile
                                                                v-for="subtask in  detailProject.All_SubTask.filter(obj=>obj.Task == task.Nama)"
                                                                :key="subtask.Id_Sub_Item_Pekerjaan"
                                                                class="d_sub_task pl-2 pr-5 mr-3 ">
                                                                <v-list-tile-content>
                                                                    <v-list-tile-title>{{ subtask.Nama }}
                                                                        <span class="pl-5"> {{subtask.Remaining}}</span>
                                                                    </v-list-tile-title>
                                                                </v-list-tile-content>
                                                                <v-list-tile-action style="min-width:150px; !important">
                                                                    <v-progress-linear
                                                                    color="red"
                                                                    height="20"
                                                                    :value="subtask.Progress"
                                                                    >
                                                                    <p class="text-xs-center">{{subtask.Progress}}%</p>
                                                                    </v-progress-linear>
                                                                </v-list-tile-action>
                                                                </v-list-tile>
                                                            
                    
                                                            
                                                            </v-list-group>

                
                                                            
                                                        </v-list-group>
                                                    
                                        
                                                        <!-- <v-list-tile-action>
                                                        <v-icon>{{ div.action }}</v-icon>
                                                        </v-list-tile-action> -->
                                                    </v-list-group>
                                                </v-list-group>
                                            </v-list>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12 md6>
                                    <v-card color="grey darken-2" height="100%" style="margin:4px;">
                                        <v-card-title class="justify-center">
                                            <span class="headline">Project Contributor</span>
                                        </v-card-title>
                                        <v-card-text> 
                                            
                                            <v-spacer></v-spacer>
                                            <v-text-field style="width:30%; padding:5px;"
                                                v-model="search"
                                                append-icon="search"
                                                label="Search"
                                                single-line
                                                hide-details
                                            ></v-text-field>
                                            <v-data-table
                                            :headers="headers"
                                            :items="d_user"
                                            :search="search"
                                            item-key="Nama"
                                            >
                                            <template v-slot:items="props">
                                                <tr @click="props.expanded = !props.expanded">
                                                <td>{{ props.item.Nama }}</td>
                                                <td class="text-sm-center">{{ props.item.Division }}</td>
                                                <td class="text-sm-center">{{ props.item.Contribute }}</td>

                                                </tr>
                                            </template>
                                            <template v-slot:expand="props">
                                                <v-card flat v-for="task in props.item.Task_List" :key="task.Nama">
                                                    <v-card-text>
                                                        <v-layout row wrap>
                                                        {{task.Div}} > {{task.Sub_Div}} > {{task.Task}} > {{task.Name}}
                                                        <v-spacer/>
                                                        {{task.Contribute}}%
                                                        </v-layout>
                                                        
                                                    </v-card-text>
                                                </v-card>
                                            </template>
                                            </v-data-table>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        
                    </v-card>
                    </v-dialog>
                </v-layout>
            <!-- Detail Dialog -->

            <!-- Alert -->
                <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
                <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
                </v-snackbar>
            <!-- Alert -->

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
        division: [],
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
            Id_Divisi_Role:'',
            Id_Proyek:'',
            Persentase:'',
            Tanggal_Selesai:'',
            // New:0,
        },
        defaultdivform:{
            Id_Divisi_Role:'',
            Id_Proyek:'',
            Persentase:'',
            Tanggal_Selesai:'',
            // New:0,
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
        projectContributors:[],
        projectContributorData:{
            Name : '',
            Division : '',
            Contribute : 0,
            Task_List:[],
        },
        projectContributorTask:{
            Name : '',
            Task : '',
            Sub_Div : '',
            Div : '',
            Contribute : 0,
        },
        d_user:[
            {
                Name:'Vian Handika',
                Division:'Desain Arsi',
                Contribute:'50%',
                Task_List:[
                    {
                        Sub_Task:'Denah Depan',
                        Task: 'Konsep',
                        Sub_Div:'Desain',
                        Div:'Desain Arsi',
                        contribute:'50%'
                    },
                    {
                        Sub_Task:'Denah Belakang',
                        Task: 'Konsep',
                        Sub_Div:'Desain',
                        Div:'Desain Arsi',
                        contribute:'50%'
                    }
                ]
            }
        ],
        //Data Dummy
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
        // d_user:[
        //     {
        //         name:'Vian Handika',
        //         division:'Desain Arsi',
        //         contribute:'50%',
        //         task_list:[
        //             {
        //                 name:'Denah Depan',
        //                 task: 'Konsep',
        //                 sub_div:'Desain',
        //                 contribute:'50%'

        //             },
        //             {
        //                 name:'Denah Belakang',
        //                 task: 'Konsep',
        //                 sub_div:'Desain',
        //                 contribute:'50%'

        //             }
        //         ]
        //     }
        // ],
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
            this.jobAksesData = (await Controller.getalljobakses()).data.filter(obj=>obj.Id_Akun == this.Id_Akun)
            this.division=(await Controller.getalldivisirole()).data
            console.log(this.division)
            // console.log(this.jobAksesData)
            // this.employeeData = data.filter(obj => obj.Divisi != "Admin");
            // console.log(data)
            // console.log(this.logPengerjaanData)
            
            console.log("DATA")
            console.log(data)
            for(let item of data){
                this.getDataFormat(item)
            }
            this.tempProjects=data
            // this.tempProjects=Object.assign({},data)
            // console.log(data)
            // console.log(this.tempProjects)
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
        // let eachDiv = div.map()
            let eachdiv ={
                Id_Divisi_Proyek    : div.Id_Divisi_Proyek,
                Id_Divisi_Role      : div.Id_Divisi_Role,
                Id_Proyek           : div.Id_Proyek,
                Nama                : div.Nama,
                Tanggal_Selesai     : div.Tanggal_Selesai.split(' ')[0],
                Persentase          : div.Persentase,
                // New                 : 0,
            }
            // console.log(JSON.stringify(eachdiv, null, 2))
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
                            console.log(eachsubtask.Log_Pengerjaan)
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
            if(this.editTask.Progress == 100)
            {
                await this.accessDone()
            }
            else
            {
                await this.duplicateEmptyLog()
            }
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
        for(let div of this.division)
        {
            if(div.Id_Divisi_Role == this.divform.Id_Divisi_Role)
            {
                this.divform.Nama = div.Deskripsi;
                break;
            }
        }
        if(this.editmode==true)
        {
            this.divform.Id_Proyek = this.editProject.Id_Proyek
            // this.divform.New = 1
        }
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

        // PROJECT CONTRIBUTOR,

        let PCDatas = [];
        let Names = [];
        //filter yang id proyeknya sesuai detail dan progress != 0
        let PCLogPengerjaan = this.logPengerjaanData.filter(obj=>obj.Id_Proyek == project.Id_Proyek && obj.Progress != 0);
        //sort berdasarkan sub item pekerjaan untuk mempermudah langkah selanjutnya
        PCLogPengerjaan.sort((a,b) => a['Id_Sub_Item_Pekerjaan'] < b['Id_Sub_Item_Pekerjaan'] ? -1 : 1) 
        // console.log(PCLogPengerjaan)
        //mengambil data nama dan divisi dari karyawan yang melakukan kontribusi
        for(let log of PCLogPengerjaan)
        {
            if(Names.indexOf(log.Nama) === -1)
            {
                let Data = { Nama:'', Division:'' }
                Names.push(log.Nama)
                Data.Nama=log.Nama;
                Data.Division=log.Divisi;
                PCDatas.push(Data)
            }
            // console.log(PCDatas)
        }
        
        console.log("PCDATA")
        console.log(PCDatas)

        let subtasks = []
        let id_subtasks = []
        let id_subtask = 0
        let index = 0
        let isNew = true
        let logs = []
        let dataTask = { Name : '', Task : '', Sub_Div : '', Div : '', Contribute : 0, Logs : [] }
        for(let log of PCLogPengerjaan)
        {
            index = id_subtasks.indexOf(log.Id_Sub_Item_Pekerjaan)
            if(index === -1)
            {
                if(isNew==false)
                {
                    // console.log("Is new = "+isNew+" Assigning")
                    dataTask.Logs = logs;
                    subtasks.push(dataTask);
                }
                logs = []
                dataTask = { Name : '', Task : '', Sub_Div : '', Div : '', Contribute : 0, Logs : [] }
                id_subtasks.push(log.Id_Sub_Item_Pekerjaan)
                dataTask.Name   = log.Sub_Task;
                dataTask.Task   = log.Task;
                dataTask.Sub_Div= log.Sub_Divisi;
                dataTask.Div    = log.Divisi;
                logs.push(log)
                isNew = false
            }
            else
            {
                // console.log("pushing log to logs")
                logs.push(log);
            }
        }
        dataTask.Logs = logs;
        subtasks.push(dataTask);

        // subtasks.Logs = logs;
        // subtasks.Logs = logs;
        console.log("ID SUBTASK")
        console.log(id_subtasks)
        console.log("LOG PER SUBTASK")
        console.log(subtasks)

        let subtasklen  = subtasks.length
        let Tasks = []
        let Contribute = 0
        // console.log("subtasklen")
        // console.log(subtasklen)
        for(let PCData of PCDatas)
        {
            PCData.Task_List = []
        }
        for(let subtask of subtasks)
        {
            let loglen      = subtask.Logs.length
            let logs        = subtask.Logs
            console.log("LOGS")
            console.log(logs)
            
            let Task = []
            // let Contribute = 0
            for(let i = 0 ; i<loglen ; i++)
            {
                console.log("LOGLEN : "+loglen)
                console.log("TASK CONTRIBUTE FOR : "+Contribute)
                for(let PCData of PCDatas)
                {
                    console.log("PCData NAME : "+PCData.Nama)
                    console.log("Log NAME : "+logs[i].Nama)
                    if(PCData.Nama == logs[i].Nama)
                    {
                        // PCData.Task_List.Name   = logs[i].Sub_Task
                        // PCData.Task_List.Task   = logs[i].Task
                        // PCData.Task_List.Sub_Div= logs[i].Sub_Divisi
                        // PCData.Task_List.Div    = logs[i].Divisi
                        if(i==0)
                        {
                            Contribute = logs[i].Progress
                            Task.Name = logs[i].Sub_Task
                            Task.Task = logs[i].Task
                            Task.Sub_Div = logs[i].Sub_Divisi
                            Task.Div = logs[i].Divisi
                            Task.Contribute = Contribute
                            // Task = {
                            //     Name    : logs[i].Sub_Task,
                            //     Task    : logs[i].Task,
                            //     Sub_Div : logs[i].Sub_Divisi,
                            //     Div     : logs[i].Divisi,
                            //     Contribute : Contribute,
                            // }
                            console.log("TASK CONTRIBUTE I : "+Task.Contribute)
                        }
                        else if(logs[i].Nama == logs[i-1].Nama)
                        {
                            console.log("TASK CONTRIBUTE BEFORE : "+Contribute)
                            Contribute += logs[i].Progress - logs[i-1].Progress
                            Task.Name = logs[i].Sub_Task
                            Task.Task = logs[i].Task
                            Task.Sub_Div = logs[i].Sub_Divisi
                            Task.Div = logs[i].Divisi
                            Task.Contribute = Contribute
                            console.log("LOG PROGRESS - i"+logs[i].Progress)
                            console.log("LOG PROGRESS - i"+logs[i-1].Progress)
                            console.log("TASK CONTRIBUTE ELSE IF : "+Contribute)
                        }
                        else
                        {
                            console.log("TASK CONTRIBUTE BEFORE : "+Contribute)
                            Contribute = logs[i].Progress - logs[i-1].Progress
                            Task.Name = logs[i].Sub_Task
                            Task.Task = logs[i].Task
                            Task.Sub_Div = logs[i].Sub_Divisi
                            Task.Div = logs[i].Divisi
                            Task.Contribute = Contribute
                            console.log("LOG PROGRESS - i"+logs[i].Progress)
                            console.log("LOG PROGRESS - i"+logs[i-1].Progress)
                            console.log("TASK CONTRIBUTE ELSE : "+Contribute)
                        }
                        if(i==loglen-1)
                        {
                            console.log("IF")
                            console.log("TASK")
                            console.log(Task)
                            // PCData.Task_List=Task
                            PCData.Task_List.push(Task);
                            Task = [];
                            Contribute = 0;
                            console.log("REFRESH")
                            // console.log(Task)
                            // console.log(Contribute)
                        }
                        else if(logs[i+1].Nama != logs[i].Nama)
                        {
                            console.log("ELSE IF")
                            console.log("TASK")
                            console.log(Task)
                            PCData.Task_List.push(Task);
                            // PCData.Task_List.push(Task)
                            Task = [];
                            Contribute = 0;
                            // console.log(Task)
                            // console.log(Contribute)
                        }
                    }
                }
            }
        }
        console.log("PCDatas")
        console.log(PCDatas)
        Contribute = 0
        let TContribute = 0
        let SDContribute = 0
        let DContribute = 0
        let PersentaseTask = 0
        let PersentaseSubDivisi = 0
        let PersentaseDivisi = 0
        let PersentaseProyek = 0
        for(let PCData of PCDatas)
        {
            for(let Task_List of PCData.Task_List)
            {
                PersentaseTask      = this.detailProject.All_SubTask.find(obj=>obj.Nama == Task_List.Name).Persentase/100
                PersentaseSubDivisi = this.detailProject.All_Task.find(obj=>obj.Nama == Task_List.Task).Persentase/100
                PersentaseDivisi    = this.detailProject.All_SubDivisi.find(obj=>obj.Nama == Task_List.Sub_Div).Persentase/100
                PersentaseProyek    = this.detailProject.All_Divisi.find(obj=>obj.Nama == Task_List.Div).Persentase/100
                
                TContribute     = Task_List.Contribute * PersentaseTask
                SDContribute    = TContribute * PersentaseSubDivisi
                DContribute     = SDContribute * PersentaseDivisi
                Contribute      +=DContribute * PersentaseProyek

                console.log(Contribute)
                // for(let divisi of this.detailProject.All_Divisi.filter(obj=>obj.Divisi == Task_List.Divisi))
                // {
                //     for(let sub_divisi of this.detailProject.All_SubDivisi.filter(obj=>obj.Nama == Task_List.Sub_Div))
                //     {
                //         for(let task of this.detailProject.All_Task.filter(obj=>obj.Nama == Task_List.Task))
                //         {
                //             for(let sub_task of this.detailProject.All_SubTask.filter(obj=>obj.Nama == Task_List.Name))
                //             {
                //                 // Contribute+=((((Task_List.Contribute*sub_task.Persentase/100)*task.Persentase/100)*sub_divisi.Persentase/100)*divisi.Persentase/100);
                //                 console.log(" .")
                //                 TContribute = Task_List.Contribute*task.Persentase/100
                //                 console.log("Task Persentase"+task.Persentase)
                //                 console.log("TContribute"+TContribute)
                //                 SDContribute = TContribute*sub_divisi.Persentase/100
                //                 Contribute += SDContribute*divisi.Persentase/100
                //                 console.log("CONTRIBUTE DALAM "+Contribute)
                //                 // console.log("TEST SUB DIVISI");
                //                 console.log("Nama : "+PCData.Nama)
                //                 console.log("Sub_Task: "+Task_List.Name)
                //                 console.log("Id_Proyek : "+divisi.Id_Proyek)
                //                 console.log("Id_Divisi_Role : "+divisi.Id_Divisi_Role)
                //                 console.log("Id_Sub_Divisi : "+sub_divisi.Id_Sub_Divisi_Proyek)
                //                 console.log("Id_Task : "+task.Id_Item_Pekerjaan)
                //                 console.log("Id_Sub_Task : "+sub_task.Id_Sub_Item_Pekerjaan)
                //             }
                //         }
                //     }
                // }
        // Task.Name
        // Task.Task
        // Task.Sub_Div 
        // Task.Div
        
                // for(let task of this.detailProject.All_Task)
                // {
                //     for(let subtask of this.detailProject.All_SubTask.filter(obj=>obj.Task == task.Nama))
                //     {
                //         task.Progress +=  subtask.Progress * subtask.Persentase/100
                //     }

                //     // task.Progress= await Controller.getProgressItem(task.Id_Item_Pekerjaan)
                // }
            }
            PCData.Contribute = Contribute
            Contribute = 0
        }


        this.d_user = PCDatas
        // 1 for perulangan untuk lognya dulu, cari yang proyeknya sesuai
        // 2 kelompokkan berdasarkan sub tasknya
        // 3 cek log index skrg dengan index berikutnya apakah namanya sama 
        // 4 jika sama, maka pembanding di geser
        // 5 jika beda maka progress index sekarang - index berdasarkan
        // 6 kemudian hasilnya simpan pada variabel Task_List
        // 7 jika ketemu sampai index terakhir, maka dikurangi dengan 0
        // 8 lakukan langkah 6

            
        // let subtasks = []
        // let id_subtask = []
        

            // let Task = []

            // Task.Name   = logs[i].Sub_Task
            // Task.Task   = logs[i].Task
            // Task.Sub_Div= logs[i].Sub_Divisi
            // Task.Div    = logs[i].Divisi
            // if(i==0)
            // {
            //     Task.Contribute = logs[i].Progress
            // }
            // else if(logs[i].Nama == logs[i-1].Nama)
            // {
            //     Task.Contribute += logs[i].Progress - logs[i-1].Progress
            // }
            // if(i==loglen-1)
            // {
            //     console.log("IF")
            //     PCData.Task_List = Task
            //     // PCData.Task_List.push(Task)
            // }
            // else if(logs[i+1].Nama != logs[i].Nama)
            // {
            //     console.log("ELSE IF")
            //     PCData.Task_List = Task
            //     // PCData.Task_List.push(Task)
            // }
            // console.log("TASK")
            // console.log(Task)

        // for(let log of PCLogPengerjaan)
        // {
        //     if(id_subtask.indexOf(log.Id_Sub_Item_Pekerjaan) === -1)
        //     {
        //         let dataTask = { Name : '', Task : '', Sub_Div : '', Div : '', Contribute : 0 }
        //         id_subtask.push(log.Id_Sub_Item_Pekerjaan)
        //         dataTask.Name   = log.Sub_Task;
        //         dataTask.Task   = log.Task;
        //         dataTask.Sub_Div= log.Sub_Divisi;
        //         dataTask.Div    = log.Divisi;
        //         subtasks.push(dataTask);
        //     }
        // }

        // console.log("LENGTH")
        // console.log(PCDatas.length)
        // for(let PCData of PCDatas)
        // {
        //     let PCLog = this.logPengerjaanData.filter(obj=>obj.Id_Proyek == project.Id_Proyek && obj.Nama == PCData.Nama)
        //     console.log("FOR LOG")
        //     console.log(PCLog)
        //     console.log("FOR DATA")
        //     console.log(PCData)
        // }
        // console.log("PCDATA")
        // console.log(PCDatas)

        // projectContributors:[],
        // projectContributorData:{
        //     Name : '',
        //     Division : '',
        //     Contribute : '',
        //     Task_List:[],
        // },
        // projectContributorTask:{
        //     Name : '',
        //     Task : '',
        //     Sub_Div : '',
        //     Div : '',
        //     Contribute : '',
        // },
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

    getSubDivision(project){
        this.sub_division = project.All_SubDivisi.filter(obj=>obj.Divisi == this.filterDiv)
        this.filterSubDiv=''
        this.filterTask=''
    },
    getTask(project){
        this.task = project.All_Task.filter(obj=>obj.Sub_Divisi == this.filterSubDiv)
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
                    return data.filter(obj=>obj.Divisi==this.filterDiv && obj.Sub_Divisi==this.filterSubDiv && obj.Task==this.filterTask )

                }
                else{
                    return data.filter(obj=>obj.Divisi==this.filterDiv && obj.Sub_Divisi==this.filterSubDiv)
                    
                }

            }
            else{
                return data.filter(obj=>obj.Divisi==this.filterDiv)
            }
        }
        else 
        {
            return data
        }
    },

    clearFilter(){
        this.filterDiv='';
        this.filterSubDiv='';
        this.filterTask='';

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
        
    },
    async duplicateEmptyLog(){
        try {
          let payloadLog ={
              Id_Sub_Item_Pekerjaan : this.editTask.Id_Sub_Item_Pekerjaan,
              Id_Akun : this.Id_Akun
          } 
          const response = await Controller.addlogpengerjaan(payloadLog)

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Mengirim Request')

        }
    },
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