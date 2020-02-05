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
        <!-- <material-card
          color="green"
          title="User Profile"
          text="Complete your profile"
        > -->
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
                  :prev-icon="prevIcon ? 'mdi-arrow-left-bold-box-outline' : undefined"
                  :next-icon="nextIcon ? 'mdi-arrow-right-bold-box-outline' : undefined"
                  :icons-and-text="icons"
                >
                  <v-tabs-slider></v-tabs-slider>

                  <v-tab>My Productivity</v-tab>
                  <v-tab-item>
                    <v-card
                      flat
                      tile
                      class="pa-4"
                    >
                    <!-- Expand Panel -->
                    <v-expansion-panel >
                        <v-expansion-panel-content
                        v-for="project in Projects" 
                        :key="project.Nama"
                        expand-icon="mdi-menu-down"
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
                    <!-- DASHBOARD CARDS -->
                      <!-- <div>
                        <h1 class="subheading grey--text">Dashboard</h1>
                          <v-container>
                            <v-layout row wrap>
                              <v-flex sm 6 xs12 md6 lg6>
                                <v-card class="ma-3">
                                  <v-list>
                                    <v-list-tile-avatar>
                                      <v-sheet color="green" width="60" height="60" elevation="10">
                                        <v-icon dark large>
                                          store
                                        </v-icon>
                                      </v-sheet>
                                      <v-card-text class="text-xs-center">
                                        <h4 class="card-title font-weight-bold">Project</h4>
                                      </v-card-text>
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                      <v-divider light></v-divider>
                                      <v-list-tile-title class="hheadline mb-1 text-right">10921</v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-card-action>
                                      <v-icon class="ma-2" dark text person></v-icon>
                                      <div class="overline"></div>
                                    </v-card-action>
                                  </v-list>
                                </v-card>
                              </v-flex>
                            </v-layout>
                          </v-container>
                        </div> -->
                        <!-- DASHHBOARD CARDS -->
                    </v-card>
                  </v-tab-item>  
                </v-tabs>
              </div>
            </v-container>
          </v-form>
        <!-- </material-card> -->
      </v-flex>
      <!-- PROFILE -->
      <v-flex
        xs12
        md4
      >
        <material-card class="v-card-profile">
          <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="130"
          >
            <img
              src="https://demos.creative-tim.com/vue-material-dashboard/img/marc.aba54d65.jpg"
            >
          </v-avatar>
            <v-layout wrap>
              <v-flex
                xs12
                md12
              >
              <v-card-text class="text-xs-center">
                <h4 class="card-title font-weight-bold">{{User.Nama}}</h4>
              </v-card-text>
              </v-flex>
              <v-flex
                xs12
                md6
              >
                <v-text-field
                  v-model="User.Jabatan"
                  disabled
                />
              </v-flex>
              <v-flex
                xs12
                md6
              >
                <v-text-field
                  v-model="User.Divisi"
                  disabled
                />
              </v-flex>
              <v-flex
                xs12
                md6
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
              >
                <v-textarea
                  clearable
                  clear-icon="cancel"
                  label="Alamat"
                  v-model="User.Alamat"
                  counter
                ></v-textarea>
              </v-flex>
              <v-flex
                xs12
                md6
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
              >
                <v-btn
                  color="success"
                  round
                  class="font-weight-light"
                  @click="updateProfile()"
                >Update Profile
                </v-btn>  
              </v-flex>
              <v-flex
                xs12
                md12
              >
                <v-btn
                  color="success"
                  round
                  class="font-weight-light"
                  @click="passwordDialog = true"
                >Change Password
                </v-btn>  
              </v-flex>
            </v-card-text>
        </material-card>
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
    <!-- Change Password Dialog -->
    <!-- PROFILE -->
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
    New_Password : '',
    Old_Password : '',
    Confirm_Password : '',
    showOPassword: false,
    showNPassword: false,
    showCPassword: false,
    //Projects
    Projects : [],
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
      this.getAllEmployees()
      this.getAllProjects()
    },
    async getAllProjects()
    {
      try {
          this.Projects = ((await Controller.getallproject()).data)
          console.log(this.Projects)
      } catch (err) {
          console.log(err)
      }
    },
    async getAllEmployees()
    {
      try {
          this.User = ((await Controller.getallemployee()).data).filter(obj=>obj.Id_Akun == this.id_akun)[0]
          this.User.Tanggal_Masuk = this.User.Tanggal_Masuk.toString()
          console.log(this.User)
      } catch (err) {
          console.log(err)
      }
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










