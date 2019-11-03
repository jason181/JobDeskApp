<template>
    <div class="jobdesk">
        <v-container>
            <v-layout justify-start class="mb-3">
                <h3 style="border-bottom:white solid 3px;">LIST PROJECT</h3>
            </v-layout>

            <v-layout row class="mb-3">
                <v-btn small flat color="grey" @click="addDialog2=true" slot="activator">
                    <v-icon small left>create_new_folder</v-icon>
                    <span class="caption ">Add Project</span>
                </v-btn>
            </v-layout>

           <!-- Expand Panel -->
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
                        <v-spacer/>
                        <v-flex>
                            <v-btn small @click="detailDialog = !detailDialog">Detail</v-btn>
                        </v-flex>  
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
                            :items="division"
                            item-text="name"
                            item-value="name"
                            box
                            label="Divison"
                            @change="getSubDivision()"

                            ></v-select>
                        </v-flex>
                        <v-flex class="pl-2" xs12 sm6 md2 >
                            <v-select
                             v-model="filterSubDiv"
                            :items="sub_division"
                            item-text="name"
                            item-value="name"
                            box
                            label="Sub Division"
                            @change="getTask()"
                            ></v-select>
                        </v-flex>     
                        <v-flex class="pl-2" xs12 sm6 md2 >
                            <v-select
                            v-model="filterTask"
                            :items="task"
                            item-text="name"
                            item-value="name"
                            box
                            label="Task"
                            ></v-select>
                        </v-flex>
                        <v-flex class="pl-2" xs12 sm6 md2 >
                            <v-btn  @click="clearFilter()">Clear</v-btn>
                        </v-flex>
                        </v-layout> 
                    </v-card>   

                    <v-card hover v-ripple class="scroll-y" v-for="task in filteredTask(project.tasks)" :key="task.title" flat style="background: #424242 !important;" @click="openTaskDialog(task)">
                    <v-layout row wrap :class="`pa-3  project ${task.status}`">
                        <v-flex xs12 md4 >
                            <div class="caption grey--text">{{task.division}}</div>
                            <div>{{task.sub_division}}</div>
                        </v-flex>
                        <v-flex xs6 sm4 md2>
                            <div class="caption grey--text">{{task.task}}</div>
                            <div>{{task.sub_task}}</div>
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
           <!-- Expand Panel -->

              <!-- Task Dialog -->
                <v-layout row justify-center>
                    <v-dialog v-model="taskDialog" scrollable persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{editTask.project}}</span>
                            <v-spacer/>
                            <span v-if="editTask.status!='untake'">Taken By : {{editTask.user}}</span>
                        </v-card-title>
                        <v-divider/>
                        <span class="ml-4">Desain Arsi > Desain > Konsep</span>

                        <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                            
                            <!-- Task -->
                            <v-flex xs12>
                                <v-text-field 
                                v-model="editTask.sub_task" 
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

                            <!-- Log Progress -->
                            <v-flex xs12>
                            <v-list subheader>
                                <v-subheader>Log Progress</v-subheader>
                                <v-divider/>
                                <v-list-tile
                                    v-for="(item) in log_pengerjaan"
                                    :key="item.id"
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
                                            <div>{{item.fileName}}</div>
                                        </v-flex>

                                        <v-flex xs6>
                                            <div class="caption grey--text">Date</div>
                                            <div>{{item.date}}</div>
                                        </v-flex>
                                    </v-layout>

                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-layout row>
                                            <v-flex xs6>
                                            <v-btn @click="downloadWithVueResource(item)" icon ripple>
                                                <v-icon color="grey lighten-1">cloud_download</v-icon>
                                            </v-btn>
                                            </v-flex>
                                            <v-flex xs6>

                                            <v-btn @click="noteDialog = !noteDialog; noteText=item.note"  icon ripple>
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
                        <v-spacer></v-spacer>
                        
                        <v-btn color="blue darken-1" flat @click="taskDialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" v-if="editTask.status=='untake'" flat @click="taskDialog = false">Take</v-btn>
                        <v-btn color="blue darken-1" v-else flat @click="taskDialog = false">Save</v-btn>

                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-layout>
              <!-- Task Dialog -->

              <!-- Add Dialog 2 -->
               <v-layout row justify-center>
                    <v-dialog v-model="addDialog2" persistent fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar>
                            <v-btn icon dark @click="addDialog2 = false">
                                <v-icon>close</v-icon>
                            </v-btn>
                            <v-toolbar-title class="white--text">Add Project</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn dark flat @click="addDialog2=false">Save</v-btn>
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
                                                <!-- <v-stepper-header>
                                                <v-stepper-step :complete="e1 > 1" step="1">Name of step 1</v-stepper-step>

                                                <v-divider></v-divider>

                                                <v-stepper-step :complete="e1 > 2" step="2">Name of step 2</v-stepper-step>

                                                <v-divider></v-divider>

                                                <v-stepper-step :complete="e1 > 3" step="3" >Name of step 3</v-stepper-step>

                                                <v-divider></v-divider>

                                                <v-stepper-step step="4">Name of step 4</v-stepper-step>


                                                </v-stepper-header> -->

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
                                                                    <v-flex xs12>
                                                                        <v-text-field 
                                                                        box
                                                                        v-model="editProject.title" 
                                                                        label="Project Name" 
                                                                        prepend-icon="contact_support"
                                                                        height=2
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
                                                                    <v-text-field 
                                                                        v-model="divform.name"
                                                                        label="Name"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="divform.contribute"
                                                                        label="Contribute"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="divform.due_date"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
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
                                                                :items="editProject.ad_division"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.name"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                     
                                                                       
                                                                    > {{ props.item.name }}
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.contribute"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.contribute }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.contribute"
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
                                                                        :return-value.sync="props.item.due_date"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.due_date }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.due_date"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
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
                                                                    :items="editProject.ad_division"
                                                                    v-model ="subdivform.division"
                                                                    item-text="name"
                                                                    item-value="name"
                                                                    box
                                                                    label="Divisi"
                                                                    ></v-select>
                                                                    <v-text-field 
                                                                        v-model="subdivform.name"
                                                                        label="Name"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="subdivform.contribute"
                                                                        label="Contribute"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="subdivform.due_date"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
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
                                                                :items="editProject.ad_subdivision"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.division"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                     
                                                                       
                                                                    > <div>{{ props.item.division }}</div>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field> -->
                                                                        <v-select
                                                                        :items="editProject.ad_division"
                                                                        v-model ="props.item.division"
                                                                        item-text="name"
                                                                        item-value="name"
                                                                        box
                                                                        label="Divisi"
                                                                        ></v-select>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.name"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                     
                                                                       
                                                                    > <div>{{ props.item.name }}</div>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.contribute"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.contribute }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.contribute"
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
                                                                        :return-value.sync="props.item.due_date"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.due_date }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.due_date"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
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
                                                                    :items="editProject.ad_subdivision"
                                                                    v-model ="taskform.subdivision"
                                                                    item-text="name"
                                                                    item-value="name"
                                                                    box
                                                                    label="Sub Divisi"
                                                                    ></v-select>
                                                                    <v-text-field 
                                                                        v-model="taskform.name"
                                                                        label="Name"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="taskform.contribute"
                                                                        label="Contribute"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="taskform.due_date"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
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
                                                                :items="editProject.ad_task"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.subdivision"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                     
                                                                       
                                                                    > <div>{{ props.item.subdivision }}</div>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field> -->
                                                                        <v-select
                                                                        :items="editProject.ad_subdivision"
                                                                        v-model ="props.item.subdivision"
                                                                        item-text="name"
                                                                        item-value="name"
                                                                        box
                                                                        label="Sub Divisi"
                                                                        ></v-select>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.name"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                     
                                                                       
                                                                    > <div>{{ props.item.name }}</div>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.contribute"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.contribute }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.contribute"
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
                                                                        :return-value.sync="props.item.due_date"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.due_date }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.due_date"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
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
                                                        <v-card-text>
                                                            <v-container>
                                                                <v-toolbar flat  color="grey darken-3">
                                                                    <v-select
                                                                    :items="editProject.ad_task"
                                                                    v-model ="subtaskform.task"
                                                                    item-text="name"
                                                                    item-value="name"
                                                                    box
                                                                    label="Task"
                                                                    ></v-select>
                                                                    <v-text-field 
                                                                        v-model="subtaskform.name"
                                                                        label="Name"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="subtaskform.contribute"
                                                                        label="Contribute"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <v-text-field
                                                                        v-model="subtaskform.due_date"
                                                                        label="Target Date"
                                                                        box
                                                                        class="mx-1"
                                                                    ></v-text-field>
                                                                    <!-- <v-toolbar-title>My CRUD</v-toolbar-title> -->
                                                                    <v-divider
                                                                        class="mx-2"
                                                                        inset
                                                                        vertical
                                                                    ></v-divider>
                                                                    <v-btn @click="addSubTaskForm()">Add</v-btn>
                                                                </v-toolbar>

                                                                <v-data-table
                                                                :headers="subtask_headers"
                                                                :items="editProject.ad_subtask"
                                                                >
                                                                <template v-slot:items="props">
                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.task"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                     
                                                                       
                                                                    > <div>{{ props.item.task }}</div>
                                                                        <template v-slot:input>
                                                                        <!-- <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field> -->
                                                                        <v-select
                                                                        :items="editProject.ad_task"
                                                                        v-model ="props.item.task"
                                                                        item-text="name"
                                                                        item-value="name"
                                                                        box
                                                                        label="Task"
                                                                        ></v-select>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td>
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.name"
                                                                        lazy
                                                                        large
                                                                        persistent
                                                                     
                                                                       
                                                                    > <div>{{ props.item.name }}</div>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.name"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                        ></v-text-field>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                    </td>

                                                                    <td class="text-xs-center">
                                                                    <v-edit-dialog
                                                                        :return-value.sync="props.item.contribute"
                                                                        large
                                                                        lazy
                                                                        persistent
                                                                    >
                                                                        <div>{{ props.item.contribute }}</div>
                                                                        <template v-slot:input>
                                                                        <div class="mt-3 title">Update Contribute</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.contribute"
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
                                                                        :return-value.sync="props.item.due_date"
                                                                        large
                                                                        lazy
                                                                        persistent    
                                                                        
                                                                    >
                                                                        <div>{{ props.item.due_date }}</div>
                                                                        <template v-slot:input>
                                                                            <div class="mt-3 title">Update Target Date</div>
                                                                        </template>
                                                                        <template v-slot:input>
                                                                        <v-text-field
                                                                            v-model="props.item.due_date"
                                                                            label="Edit"
                                                                            single-line
                                                                            counter
                                                                            autofocus
                                                                        ></v-text-field>
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
                                    <v-card color="grey darken-2" height="100%" style="margin:4px;">
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
                                                        <span>{{editProject.title}}</span>
                                                       
                                                        <!-- <v-btn small color="info">Detail</v-btn> -->
                                                        </v-list-tile-title>
                                                    </v-list-tile-content>
                                                    
                                                    </v-list-tile>
                                                </template>
                                    
                                                    <v-list-group
                                                        v-for="(div,index) in editProject.ad_division"
                                                        :key="index"
                                                        class="pl-2 pr-2"
                                                        :value="expandDetail"
                                                        
                                                    >
                                                        <template v-slot:activator>
                                                            <v-list-tile class="d_div">
                                                            <v-list-tile-content>
                                                                <v-list-tile-title>{{ div.name }}
                                                                    <!-- <span class="pl-5"> 2 days remaining</span> -->
                                                                </v-list-tile-title>
                                                            </v-list-tile-content>
                                                            
                                                            </v-list-tile>
                                                        </template>

                                                        <v-list-group
                                                        v-for="(subdiv,index) in editProject.ad_subdivision.filter(obj => obj.division == div.name)"
                                                        :key="index"
                                                        class="pl-2 pr-2" 
                                                        :value="expandDetail"
                                                        >
                                                            <template v-slot:activator>
                                                                <v-list-tile  class="d_sub_div">
                                                                <v-list-tile-content >
                                                                    <v-list-tile-title>{{ subdiv.name }}
                                                                        <!-- <span class="pl-5"> 2 days remaining</span> -->
                                                                    </v-list-tile-title>
                                                                </v-list-tile-content>
                                                                
                                                                </v-list-tile>
                                                            </template>

                                                            <v-list-group
                                                            v-for="(task,index) in editProject.ad_task.filter(obj => obj.subdivision == subdiv.name)"
                                                            :key="index"
                                                            class="pl-2 pr-2"
                                                            :value="expandDetail"
                                                            >
                                                                <template v-slot:activator>
                                                                    <v-list-tile  class="d_task">
                                                                    <v-list-tile-content>
                                                                        <v-list-tile-title>{{ task.name }}
                                                                            <!-- <span class="pl-5"> 2 days remaining</span> -->
                                                                        </v-list-tile-title>
                                                                    </v-list-tile-content>
                                                                  
                                                                    </v-list-tile>
                                                                </template>
                                                                <v-list-tile
                                                                v-for="(subtask,index) in editProject.ad_subtask.filter(obj => obj.task == task.name)"
                                                                :key="index"
                                                                class="d_sub_task pl-2 pr-5 mr-3 ">
                                                                <v-list-tile-content>
                                                                    <v-list-tile-title>{{ subtask.name }}
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
                    <v-card-title class="headline">Note</v-card-title>

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
                                                        <span> Rumah Sakit Arsitektur</span>
                                                        
                                                        <span class="pl-5"> 2 days remaining</span>

                                                        <!-- <v-btn small color="info">Detail</v-btn> -->
                                                        </v-list-tile-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action style="min-width:150px; !important">
                                                         <v-progress-linear
                                                        color="red"
                                                        height="20"
                                                        :value="'70'"
                                                        >
                                                        <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                                        <p class="text-xs-center">70%</p>
                                                        </v-progress-linear>
                                                    </v-list-tile-action>
                                                    </v-list-tile>
                                                </template>
                                    
                                                    <v-list-group
                                                        v-for="div in d_division"
                                                        :key="div.id"
                                                        class="pl-2 pr-2"
                                                        :value="expandDetail"
                                                        
                                                    >
                                                        <template v-slot:activator>
                                                            <v-list-tile class="d_div">
                                                            <v-list-tile-content>
                                                                <v-list-tile-title>{{ div.name }}
                                                                    <span class="pl-5"> 2 days remaining</span>
                                                                </v-list-tile-title>
                                                            </v-list-tile-content>
                                                            <v-list-tile-action style="min-width:150px; !important">
                                                                <v-progress-linear
                                                                color="red"
                                                                height="20"
                                                                :value="div.progress"
                                                                >
                                                                <!-- <strong class="text-center">{{project.progress}}%</strong> -->
                                                                <p class="text-xs-center">{{div.progress}}%</p>
                                                                </v-progress-linear>
                                                            </v-list-tile-action>
                                                            </v-list-tile>
                                                        </template>

                                                        <v-list-group
                                                        v-for="subdiv in d_sub_division"
                                                        :key="subdiv.id"
                                                        class="pl-2 pr-2" 
                                                        :value="expandDetail"
                                                        >
                                                            <template v-slot:activator>
                                                                <v-list-tile  class="d_sub_div">
                                                                <v-list-tile-content >
                                                                    <v-list-tile-title>{{ subdiv.name }}
                                                                        <span class="pl-5"> 2 days remaining</span>
                                                                    </v-list-tile-title>
                                                                </v-list-tile-content>
                                                                <v-list-tile-action style="min-width:150px; !important">
                                                                    <v-progress-linear
                                                                    color="red"
                                                                    height="20"
                                                                    :value="subdiv.progress"
                                                                    >
                                                                    <p class="text-xs-center">{{subdiv.progress}}%</p>
                                                                    </v-progress-linear>
                                                                </v-list-tile-action>
                                                                </v-list-tile>
                                                            </template>

                                                            <v-list-group
                                                            v-for="task in d_task"
                                                            :key="task.id"
                                                            class="pl-2 pr-2"
                                                            :value="expandDetail"
                                                            >
                                                                <template v-slot:activator>
                                                                    <v-list-tile  class="d_task">
                                                                    <v-list-tile-content>
                                                                        <v-list-tile-title>{{ task.name }}
                                                                            <span class="pl-5"> 2 days remaining</span>
                                                                        </v-list-tile-title>
                                                                    </v-list-tile-content>
                                                                    <v-list-tile-action style="min-width:150px; !important">
                                                                        <v-progress-linear
                                                                        color="red"
                                                                        height="20"
                                                                        :value="task.progress"
                                                                        >
                                                                        <p class="text-xs-center">{{task.progress}}%</p>
                                                                        </v-progress-linear>
                                                                    </v-list-tile-action>
                                                                    </v-list-tile>
                                                                </template>
                                                                <v-list-tile
                                                                v-for="subtask in d_sub_task"
                                                                :key="subtask.id"
                                                                class="d_sub_task pl-2 pr-5 mr-3 ">
                                                                <v-list-tile-content>
                                                                    <v-list-tile-title>{{ subtask.name }}
                                                                        <span class="pl-5"> 2 days remaining</span>
                                                                    </v-list-tile-title>
                                                                </v-list-tile-content>
                                                                <v-list-tile-action style="min-width:150px; !important">
                                                                    <v-progress-linear
                                                                    color="red"
                                                                    height="20"
                                                                    :value="subtask.progress"
                                                                    >
                                                                    <p class="text-xs-center">{{subtask.progress}}%</p>
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
                                            item-key="name"
                                            >
                                            <template v-slot:items="props">
                                                <tr @click="props.expanded = !props.expanded">
                                                <td>{{ props.item.name }}</td>
                                                <td class="text-sm-center">{{ props.item.division }}</td>
                                                <td class="text-sm-center">{{ props.item.contribute }}</td>

                                                </tr>
                                            </template>
                                            <template v-slot:expand="props">
                                                <v-card flat v-for="task in props.item.task_list" :key="task.name">
                                                    <v-card-text>
                                                        <v-layout row wrap>
                                                        {{task.sub_div}} > {{task.task}} > {{task.name}}
                                                        <v-spacer/>
                                                        {{task.contribute}}
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
        </v-container>
    </div>
</template>
<script>
export default {
  data() {
    return {
       //Base
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
        division: ['Desain Arsi', 'Admin'],
        sub_division:[],
        task:[],
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
        addDialog :false,
        taskDialog:false,
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
        addDialog2:true,
        editProject:
        {
            ad_division:[
                {
                    name:'Desain Arsi',
                    contribute:'50',
                    due_date:'',
                },
                {
                    name:'Admin',
                    contribute:'2',
                    due_date:'',
                }
            ],
            ad_subdivision:[
                {
                    name:'Desain',
                    division:'Desain Arsi',
                    contribute:'50',
                    due_date:'',
                },
                {
                    name:'QS',
                    division:'Desain Arsi',
                    contribute:'2',
                    due_date:'',
                }
            ],
            ad_task:[
                {
                    name:'Konsep',
                    subdivision:'Desain',
                    contribute:'50',
                    due_date:'',
                },
            ],
            ad_subtask:[
                {
                    name:'Denah Depan',
                    task:'Konsep',
                    contribute:'50',
                    due_date:'',
                },
            ],

            title: '', 
            start: '',
            due: '', 
            value:'',
            target_outcome:'',
            note:'',
            client_name:'',
            client_address:'',
        },
    
        div_headers: [
          { text: 'Name',align: 'left',sortable: false,value: 'name'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },

        ],
        subdiv_headers: [
          { text: 'Division',align: 'left',sortable: false,value: 'division'},
          { text: 'Name',align: 'left',sortable: false,value: 'name'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },
        ],
        task_headers: [
          { text: 'Sub Division',align: 'left',sortable: false,value: 'subdivision'},
          { text: 'Name',align: 'left',sortable: false,value: 'name'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },

        ],
        subtask_headers: [
          { text: 'Task',align: 'left',sortable: false,value: 'subdivision'},
          { text: 'Name',align: 'left',sortable: false,value: 'name'},
          { text: 'Contribute (%)', value: 'contribute',align: 'center' },
          { text: 'Target Date', value: 'due',align: 'center' },
          { text: 'Action', value:'index' ,align: 'center' },

        ],
        divform:{
            name:'',
            contribute:'',
            due_date:'',
        },
        defaultdivform:{
            name:'',
            contribute:'',
            due_date:'',
        },
        subdivform:{
            name:'',
            division:'',
            contribute:'',
            due_date:'',
        },
        defaultsubdivform:{
            name:'',
            division:'',
            contribute:'',
            due_date:'',
        },
        taskform:{
            name:'',
            subdivision:'',
            contribute:'',
            due_date:'',
        },
        defaulttaskform:{
            name:'',
            subdivision:'',
            contribute:'',
            due_date:'',
        },
        subtaskform:{
            name:'',
            task:'',
            contribute:'',
            due_date:'',
        },
        defaultsubtaskform:{
            name:'',
            task:'',
            contribute:'',
            due_date:'',
        },
       //Add Dialog 2

       //Data Dummy
        detailDialog:false,
        expandDetail:false,
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
   computed:{
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

    addDivForm(){
        this.editProject.ad_division.push(this.divform)
        this.divform = Object.assign({}, this.defaultdivform)

    },
    delDivForm(index){
        this.editProject.ad_division.splice(this.editProject.ad_division.indexOf(index), 1)
        this.editProject.ad_division = [...this.editProject.ad_division]
       
    },

    addSubDivForm(){
        this.editProject.ad_subdivision.push(this.subdivform)
        this.subdivform = Object.assign({}, this.defaultsubdivform)

    },
    delSubDivForm(index){
        this.editProject.ad_subdivision.splice(this.editProject.ad_subdivision.indexOf(index), 1)
        this.editProject.ad_subdivision = [...this.editProject.ad_subdivision]
       
    },

    addTaskForm(){
        this.editProject.ad_task.push(this.taskform)
        this.taskform = Object.assign({}, this.defaulttaskform)

    },
    delTaskForm(index){
        this.editProject.ad_task.splice(this.editProject.ad_task.indexOf(index), 1)
        this.editProject.ad_task = [...this.editProject.ad_task]
       
    },
    addSubTaskForm(){
        this.editProject.ad_subtask.push(this.subtaskform)
        this.subtaskform = Object.assign({}, this.defaultsubtaskform)

    },
    delSubTaskForm(index){
        this.editProject.ad_subtask.splice(this.editProject.ad_subtask.indexOf(index), 1)
        this.editProject.ad_subtask = [...this.editProject.ad_subtask]
       
    },

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
                    return data.filter(obj=>obj.division==this.filterDiv && obj.sub_division==this.filterSubDiv && obj.task==this.filterTask )

                }
                else{
                    return data.filter(obj=>obj.division==this.filterDiv && obj.sub_division==this.filterSubDiv)
                    
                }

            }
            else{
                return data.filter(obj=>obj.division==this.filterDiv)
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

    forceFileDownload(response){
      const url = window.URL.createObjectURL(new Blob([response.data]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', 'file.png') //or any other extension
      document.body.appendChild(link)
      link.click()
    },
    
    downloadWithVueResource(data) {
      
      this.$http({
        method: 'get',
        url: data.fileUrl,
        responseType: 'arraybuffer'
      })
      .then(response => {
        this.forceFileDownload(response)  
      })
      .catch(() => console.log('error occured'))
      
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

.d_sub_task{
  /* border-left: 4px solid #004D40 !Important;
  border-color:#004D40 !Important; */
}


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