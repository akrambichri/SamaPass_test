import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { SalaryComponent } from './salaries/salary/salary.component';
import { SalariesComponent } from './salaries/salaries.component';
import { SalaryListComponent } from './salaries/salary-list/salary-list.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { SalaryService } from './shared/salary.service';
import { HttpClientModule } from "@angular/common/http";
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ToastrModule } from 'ngx-toastr';
import { FormsModule } from "@angular/forms";
import { ModalComponent } from './salaries/modal/modal.component';
import { MatButtonModule } from '@angular/material/button';
import { MatDialogModule } from '@angular/material/dialog';



@NgModule({
  declarations: [
    AppComponent,
    SalaryComponent,
    SalariesComponent,
    SalaryListComponent,
    ModalComponent,
  ],
  imports: [
    BrowserModule,
    NgbModule,
    FormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    ToastrModule.forRoot(),
    MatButtonModule,
    MatDialogModule
  ],
  entryComponents: [
    ModalComponent
  ],
  providers: [SalaryService],
  bootstrap: [AppComponent]
})
export class AppModule { }
