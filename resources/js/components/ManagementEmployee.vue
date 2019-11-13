<template>
    <v-container>
        <v-toolbar flat>
          <v-toolbar-title class="white--text">TABEL PEGAWAI</v-toolbar-title>
          <v-divider
              class="mx-2 white"
              inset
              vertical
          ></v-divider>

          <!-- dialog box add/edit -->
          <v-dialog v-model="formDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
              <template v-slot:activator="{ on }">
              <v-btn v-if="Access('M-Employee-C')==true" color="success"  dark class="mb-2" v-on="on">Tambah</v-btn>
              </template>
              <v-card>
                    <v-toolbar>
                        <v-btn icon dark @click="close();">
                            <v-icon>close</v-icon>
                        </v-btn>
                        <v-toolbar-title class="white--text">{{ formTitle }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>

                            <v-btn dark flat v-if="editedIndex!=-1" color="blue darken-1"  @click="updateEmployee()">Save</v-btn>
                            <v-btn dark flat v-else color="blue darken-1" @click="addEmployee(editedForm);close();">Add</v-btn>

                        </v-toolbar-items>
                    </v-toolbar>
              

             
                  <v-container fluid>
                  <v-layout row wrap>
                      <v-flex xs12 sm4>
                           <v-card color="grey darken-2" height="100%" style="margin:4px;">
                                <v-card-title class="justify-center">
                                    <span class="headline">Personal Information</span>
                                </v-card-title>
                                <v-card-text > 
                                    <v-container class="grey darken-3">
                                        <v-layout row wrap>
                                            <v-flex xs12 sm8>
                                                <v-text-field 
                                                box
                                                v-model="editedForm.Nama" 
                                                label="Nama Lengkap" 
                                                prepend-icon="supervised_user_circle"
                                                ></v-text-field>
                                            </v-flex>          
                                            <v-flex xs12 sm6 >
                                                <v-text-field 
                                                box
                                                v-model="editedForm.Telepon" 
                                                label="Telepon" 
                                                prepend-icon="contact_phone"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm8>
                                                <v-text-field 
                                                box
                                                v-model="editedForm.KTP" 
                                                label="No NIK" 
                                                prepend-icon="credit_card"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm12 class="pr-2">
                                                <v-textarea    
                                                box                                     
                                                label="Alamat"
                                                v-model="editedForm.Alamat"
                                                prepend-icon="my_location"

                                                ></v-textarea>
                                            </v-flex>
                                        </v-layout>
                                        
                                    </v-container>
                                </v-card-text>
                            </v-card>
                      </v-flex>
                      <v-flex xs12 sm4>
                           <v-card color="grey darken-2" height="100%" style="margin:4px;">
                                <v-card-title class="justify-center">
                                    <span class="headline">Employee Information</span>
                                </v-card-title>
                                <v-card-text > 
                                    <v-container class="grey darken-3">
                                        <v-layout row wrap>
                                            <v-flex xs12 sm8>
                                                <v-text-field 
                                                box
                                                v-model="editedForm.Kode" 
                                                label="Kode Pegawai" 
                                                prepend-icon="contact_support"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm8>
                                                <v-menu
                                                v-model="DateIn"
                                                :close-on-content-click="false"
                                                :nudge-right="40"
                                                transition="scale-transition"
                                                offset-y
                                                full-width
                                                min-width="290px"
                                                
                                                >
                                                <template v-slot:activator="{ on }">
                                                    <v-text-field
                                                    v-model="editedForm.Tanggal_Masuk"
                                                    label="Tanggal Masuk"
                                                    prepend-icon="event"
                                                    box
                                                    v-on="on"
                                                    readonly
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker  v-model="editedForm.Tanggal_Masuk" @input="DateIn = false"></v-date-picker>
                                                </v-menu>
                                            </v-flex>

                                            <v-flex xs12 sm6 class="pr-2">
                                                <v-select
                                                :items="divisiData"
                                                v-model ="editedForm.Id_Divisi_Role"
                                                item-text="Deskripsi"
                                                item-value="Id_Divisi_Role"
                                                box
                                                label="Divisi"
                                                prepend-icon="contact_support"
                                                ></v-select>
                                            </v-flex>          
                                            <v-flex xs12 sm6 >
                                                <v-select
                                                :items="jabatanData"
                                                v-model ="editedForm.Id_Jabatan"
                                                item-text="Deskripsi"
                                                item-value="Id_Jabatan"
                                                box
                                                label="Jabatan"
                                                prepend-icon="contact_support"
                                                ></v-select>
                                            </v-flex>

                                            <v-flex xs12 sm8>
                                                <v-text-field 
                                                box
                                                v-model="editedForm.Grade" 
                                                label="Grade" 
                                                prepend-icon="contact_support"
                                                ></v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm6 >
                                                <v-text-field 
                                                box
                                                v-model="editedForm.Nomor_Asosiasi" 
                                                label="Nomor Asosiasi" 
                                                prepend-icon="contact_support"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 >
                                                <v-text-field 
                                                box
                                                v-model="editedForm.Nomor_SKA" 
                                                label="Nomor SKA" 
                                                prepend-icon="contact_support"
                                                ></v-text-field>
                                            </v-flex>
                                            
                                                                             
                                        </v-layout>
                                        
                                    </v-container>
                                </v-card-text>
                            </v-card>
                      </v-flex>
                      <v-flex xs12 sm4>
                           <v-card color="grey darken-2" height="100%" style="margin:4px;">
                                <v-card-title class="justify-center">
                                    <span class="headline">Previledge Access</span>
                                </v-card-title>
                                <v-card-text > 
                                    <v-container class="grey darken-3">
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                              <v-combobox
                                                v-model="editedForm.Akses"
                                                :items="FeatureAccess"
                                                item-text="Deskripsi"
                                                item-value="Fitur"
                                                label="Feature Access"
                                                chips
                                                clearable
                                                prepend-icon="filter_list"
                                                solo
                                                multiple
                                              >
                                                <template v-slot:selection="data">
                                                  <v-chip
                                                    :selected="data.selected"
                                                    close
                                                    @input="remove(data.item)"
                                                  >
                                                    <strong>{{ data.item.Deskripsi }}</strong>&nbsp;
                                                    <!-- <span>({{ data.item.Akses }})</span> -->
                                                  </v-chip>
                                                </template>
                                              </v-combobox>
                                            </v-flex>                                  
                                        </v-layout>
                                        
                                    </v-container>
                                </v-card-text>
                            </v-card>
                      </v-flex>
                  </v-layout>
                  </v-container>
             
              </v-card>
          </v-dialog>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Delete Item</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Are you sure want to delete this ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deleteEmployee()">Yes</v-btn>
                  <v-btn color="blue darken-1" flat @click="close">No</v-btn>
                  <v-spacer></v-spacer>

                
              </v-card-actions>
            </v-card>
          </v-dialog>          

          <!-- Search -->
          <v-spacer></v-spacer>
          <v-flex xs4 sm4 md4>
            <v-text-field 
                v-model="search"
                append-icon="search"
                label="Cari"
                single-line
                hide-details>
            </v-text-field>
          </v-flex>

        </v-toolbar>
          <!-- <VCardText
            v-if="loading || error"
            class="text-xs-center"
          >
            <VAlert
              v-if="error"
              type="error"
              dismissible
              :value="true"
            >
              {{ error.message }}
            </VAlert>
            <VProgressCircular
              :size="45"
              indeterminate
              class="loading-section"
            />
          </VCardText> -->

        <!-- Tabel -->
        <v-data-table
          :headers="headers"
          :items="initialize"
          :search="search"
          class="elevation-1">
          <template v-slot:items="props">
              <td>{{ props.index+1 }}</td>
              <td>{{ props.item.Nama }}</td>
              <td class="text-xs-center">{{ props.item.Username }}</td>
              <td class="text-xs-left">{{ props.item.Divisi }}</td>              
              <td class="text-xs-left">{{ props.item.Jabatan }}</td>
              <td class="text-xs-center">{{ props.item.Telepon }}</td>
              <td class="justify-center layout px-0">
                <v-icon
                  v-if="Access('M-Employee-U')==true"
                  small
                  class="mr-2"
                  @click="editItem(props.item)"
                >
                  edit
              </v-icon>
              <v-icon
                  v-if="Access('M-Employee-D')==true"
                  small
                  @click="deleteItem(props.item)"
              >
                  delete
              </v-icon>
              </td>
          </template>
          <v-alert v-slot:no-results :value="true" color="error" icon="warning">
              Your search for "{{ search }}" found no results.
          </v-alert>
          <!-- <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template> -->
        </v-data-table>

        <!-- Alert -->
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
          <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
    </v-container>
</template>


<script>
  import Controller from '../httpController'
  import { mapGetters } from 'vuex'
//   import { mapState, mapActions } from 'vuex'
//   import userService from '../../service/User'

  export default {
    data: () => ({
      formDialog:false,
      delDialog: false,
      DateIn:false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left', sortable: false },
        { text: 'Nama Pegawai', align: 'left', value: 'Nama' },
        { text: 'Username', align: 'center', value: 'Username', sortable: false },
        { text: 'Divisi', align: 'center', value: 'Divisi' },
        { text: 'Jabatan', align: 'center',value: 'Jabatan' },
        { text: 'Telepon', align: 'center',value: 'Telepon' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      employee:[],
      employeeData: [],
      employeeDataFiltered:[],
      divisiData:[],
      jabatanData:[],
      editedIndex: -1,
      alert:{
        type: null,
        message: null,
        icon: null,
      },
      editedForm:{
        Id_Karyawan:'',
        Nama:'',
        Telepon:'',
        KTP:'',
        Alamat:'',
        Kode:'',
        Id_Divisi_Role:'',
        Id_Jabatan:'',
        Grade:'',
        Nomor_Asosiasi:'',
        Nomor_SKA:'',
        Akses:[]

      },
      editedFormDefault:{
        Id_Karyawan:'',
        Nama:'',
        Telepon:'',
        KTP:'',
        Alamat:'',
        Kode:'',
        Id_Divisi_Role:'',
        Id_Jabatan:'',
        Grade:'',
        Nomor_Asosiasi:'',
        Nomor_SKA:'',
        Akses:[]
      },
      PreviledgeAccess:[],
      FeatureAccess:[
        {Deskripsi:"Management Employee (Create)",Fitur:"M-Employee-C"},
        {Deskripsi:"Management Employee (Read)",Fitur:"M-Employee-R"},
        {Deskripsi:"Management Employee (Update)",Fitur:"M-Employee-U"},
        {Deskripsi:"Management Employee (Delete)",Fitur:"M-Employee-D"},
        {Deskripsi:"Management Role (Create)",Fitur:"M-Role-C"},
        {Deskripsi:"Management Role (Read)",Fitur:"M-Role-R"},
        {Deskripsi:"Management Role (Update)",Fitur:"M-Role-U"},
        {Deskripsi:"Management Role (Delete)",Fitur:"M-Role-D"},
        {Deskripsi:"Job Access (Create)",Fitur:"M-JobAccess-C"},
        {Deskripsi:"Job Access (Read)",Fitur:"M-JobAccess-R"},
        {Deskripsi:"Job Access (Update)",Fitur:"M-JobAccess-U"},
        {Deskripsi:"Job Access (Delete)",Fitur:"M-JobAccess-D"},
      ]
    }),

    computed: {
      ...mapGetters({
            nama: 'LoggedUser/Name',
            jabatan: 'LoggedUser/Jabatan',
            divisi: 'LoggedUser/Divisi',
            akses:'LoggedUser/Akses',
        }),
      formTitle () {
        return this.editedIndex === -1 ? 'Add Employee' : 'Edit Employee'
      },
    //   ...mapState({
    //     loading: state => state.User.loading,
    //     error: state => state.User.error,
    //     users: state => state.User.users,
    //   }),
      initialize () {
        // this.employeeData = this.employee.filter(obj => obj.role != "Admin");
        // return this.userData
        this.employeeData = this.employee.filter(obj => obj.role != "Admin");
        return this.employeeData
      },


    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      delDialog (val) {
        val || this.close()
      }
    },

    mounted () {
      this.loaddata ()
    //   this.getEmployee()
      // this.userfiltered()
    
    },

    methods: {
    //   ...mapActions({
    //       getEmployee: 'Employee/get',
    //       deleteEmployee: 'Employee/delete',
          
    //   }),
      async loaddata () {
        try {
            const data = (await Controller.getallemployee()).data
            // this.employeeData = data.filter(obj => obj.Divisi != "Admin");
            this.employee = data.filter(obj => obj.Divisi != "Admin");
            this.jabatanData = (await Controller.getalljabatan()).data
            this.divisiData = (await Controller.getalldivisirole()).data


        } catch (err) {
            console.log(err)
        }
      },
      async getEmployee(){
        try {

            const data = (await Controller.getallemployee()).data
            this.employee = data.filter(obj => obj.Divisi != "Admin");

        } catch (err) {
            console.log(err)
        }
      },


      async addEmployee () {
        try {
            // const data ={
            //   name_branch: this.editedItem.name,
            //   address_branch : this.editedItem.address,
            // }
            this.editedForm["Username"]= this.createUsername(this.editedForm.Nama)
            console.log(this.editedForm)        
            const response= await Controller.addemployee(this.editedForm)
            console.log(response)
            this.employeeData.push(this.editedForm)
            await this.getEmployee()
            this.close()
            this.showAlert('success','Sukses Menambahkan Pegawai')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Menambahkan Pegawai')
        }
            
      },
      async deleteEmployee(){
        try {
            var id_employee = this.employeeData[this.editedIndex].Id_Karyawan
            const response = await Controller.deleteemployee(id_employee)
            console.log(response)
            await this.getEmployee()
            this.close()
            this.showAlert('success','Sukses Hapus Pegawai')

        } catch (err) {
            console.log(err)
            this.showAlert('success','Gagal Hapus Pegawai')

        }
      },
      async updateEmployee () {
        try {

            const response = await Controller.updateemployee(this.editedForm,this.editedForm.Id_Karyawan)
            console.log(response)
            Object.assign(this.employeeData[this.editedIndex], this.editedForm)
            await this.getEmployee()
            this.close()
            this.showAlert('success','Sukses Edit Pegawai')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Edit Pegawai')
        }
      },
      createUsername(fullname){
        var username = fullname
        
        // username = username.replace(/\s/g,''); //remove space
        username = username.replace(/ .*/,'');
        // console.log(username);
        username = username.toLowerCase(); //to lowercase
        // console.log(username);
        username = username+Math.floor(Math.random()*100)
        console.log(username);

        return username;

      },
      remove (item) {
        this.editedForm.Akses.splice(this.editedForm.Akses.indexOf(item), 1)
        this.editedForm.Akses = [...this.editedForm.Akses]
      },
      Access(codeAccess){

        var x;
        for(x in this.akses.data){
            if (codeAccess.includes(this.akses.data[x].Fitur)) {
                return true
            } 
        }
        return false
            
      },
    //   closeFormDialog(){
    //     this.formDialog= false
    //     this.editedForm = Object.assign({}, this.defaultItem)
    //   },
    //   userfiltered(){
    //     // console.log(this.userData)
    //     this.userDataFiltered = this.userData.filter(item => console.log(item));
    //     // console.log(this.userDataFiltered);
    //   },
      editItem (item) {
        this.editedIndex = this.employeeData.indexOf(item)
        this.editedForm = Object.assign({}, item)
        this.editedForm.Akses = this.editedForm.Akses.data
        this.formDialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.employeeData.indexOf(item)
        var id_employee = this.employeeData[this.editedIndex].Id_Karyawan
        console.log(id_employee)
        this.delDialog =true
        // confirm('Are you sure you want to delete this item?') && this.userData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deleteuser()
      },

      close () {
        this.formDialog = false
        this.delDialog = false
        setTimeout(() => {
          this.editedForm = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
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
        
      }
      
    }
  }
</script>
