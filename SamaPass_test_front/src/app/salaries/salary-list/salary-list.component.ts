import { Component, OnInit } from '@angular/core';
import { SalaryService } from 'src/app/shared/salary.service';
import { Salary } from 'src/app/shared/salary.model';
import { ToastrService } from 'ngx-toastr';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';
import { ModalComponent } from '../modal/modal.component';

@Component({
  selector: 'app-salary-list',
  templateUrl: './salary-list.component.html',
  styleUrls: ['./salary-list.component.css']
})
export class SalaryListComponent implements OnInit {

  constructor(public service: SalaryService,
    private toastr: ToastrService,
    public matDialog: MatDialog ) { }

  ngOnInit() {
    this.service.refreshList();
  }

  populateForm(sal: Salary) {
    this.service.formData = Object.assign({}, sal);
  }

  onDelete(id: number) {
    if (confirm('Are you sure to delete this record?')) {
      this.service.deleteSalary(id).subscribe(res => {
        this.service.refreshList();
        this.toastr.warning('Deleted successfully', 'Request Registered');
      });
    }
  }

  openModal(){
    const dialogConfig = new MatDialogConfig();
    // The user can't close the dialog by clicking outside its body
    dialogConfig.disableClose = false;
    dialogConfig.id = "modal-component";
    dialogConfig.height = "350px";
    dialogConfig.width = "600px";
    // https://material.angular.io/components/dialog/overview
    const modalDialog = this.matDialog.open(ModalComponent, dialogConfig);
  }

}
