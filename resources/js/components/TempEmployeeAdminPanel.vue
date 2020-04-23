<v-layout row wrap>
<v-flex xs12 sm12 md12 lg4>
    <v-layout justify-start class="mb-2 pa-3">
    <h3 style="border-bottom:white solid 3px;">EMPLOYEE LIST</h3>
    </v-layout>
    <v-select
    :items="Users"
    v-model="filter_employee"
    item-text="Nama"
    item-value="Nama"
    box
    label="Employee"
    width="100%"
    >
    </v-select>
</v-flex>
<v-flex xs12 sm12 md6 lg4 class="justify-center">
    <v-card width="100%" height="200" max-width="300px">
    <v-avatar tile>
        <v-sheet color="blue" width="75" height="75" elevation="10">
        <v-icon dark large>store</v-icon>
        </v-sheet>
    </v-avatar>
    <v-card-title class="headline right ma-1"> 
        Performance
    </v-card-title>
    <div> 
        <v-divider class="mt-4"></v-divider>
    </div>
    <v-card-text class="pa-4 ">
        <div class="title font-weight-light mb-2">Total Proyek : 1</div>
        <div class="subheading font-weight-light mb-3">Rata-rata Kontribusi : 2,685%</div>
        <v-divider style="margin:0 !important"></v-divider>
        <v-icon
        class="mr-2"
        small
        color="green"
        >
        mdi-checkbox-blank-circle
        </v-icon>
        <span class="caption grey--text font-weight-light">last upload 26 minutes ago</span>
    </v-card-text>
    </v-card>
</v-flex>
<v-flex xs12 sm12 md6 lg4>
    <v-card width="100%" height="200" max-width="300px">
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
    </v-card>
</v-flex>
</v-layout>
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
                                <v-tooltip left color="grey darken-4" style="left:-260px"> 
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