import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';
import { SalaryService } from 'src/app/shared/salary.service';
import { HttpEventType, HttpResponse } from '@angular/common/http';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-modal',
  templateUrl: './modal.component.html',
  styleUrls: ['./modal.component.css']
})
export class ModalComponent implements OnInit {
  selectedFiles: FileList;
  currentFile: File;
  progress = 0;
  message = '';
  fileInfos: Observable<any>;
  errors:any[];


  constructor(public service: SalaryService,public dialogRef: MatDialogRef<ModalComponent>) { }

  ngOnInit(): void {
  }

  selectFile(event): void {
    this.selectedFiles = event.target.files;
    this.currentFile = this.selectedFiles.item(0);
    this.errors = null;
    this.message = '';
  }

  resetFile(event): void {

    var element = event.target as HTMLInputElement  ;
    element.value = '';
  }

    upload(): void {
      this.progress = 0;

      this.currentFile = this.selectedFiles.item(0);
      this.service.upload(this.currentFile).subscribe(
        event => {
          if (event.type === HttpEventType.UploadProgress) {
            this.progress = Math.round(100 * event.loaded / event.total);
          } else if (event instanceof HttpResponse) {
            this.message = 'Data imported';
            //this.fileInfos = this.service.getFiles();
          }
        },
        err => {
          this.progress = 0;
          this.message = 'Could not upload the file!';
          this.currentFile = null;

          if(err.status === 400){
            this.errors = err.error;
            console.log(this.errors.length);
          }
        });
      this.selectedFiles = null;
    }

  // If the user clicks the cancel button a.k.a. the go back button, then\
  // just close the modal
  closeModal() {
    this.dialogRef.close();
  }
}
