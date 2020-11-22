
import { Injectable } from '@angular/core';
import { Salary } from './salary.model';
import { HttpClient, HttpRequest, HttpEvent } from "@angular/common/http";
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SalaryService {

  formData  : Salary;
  list : Salary[];
  readonly rootURL ="http://localhost:8000/api"

  constructor(private http : HttpClient) { }

  postSalary(formData : Salary){
   return this.http.post(`${this.rootURL}/salaries/`,formData);

  }

  refreshList(){
    this.http.get(`${this.rootURL}/salaries/`)
    .toPromise().then(res => this.list = res as Salary[]);
  }

  putSalary(formData : Salary){
    return this.http.put(`${this.rootURL}/salaries/${formData.id}`,formData);

   }

   deleteSalary(id : number){
    return this.http.delete(`${this.rootURL}/salaries/+${id}`);
   }

  upload(file: File): Observable<HttpEvent<any>> {
    const formData: FormData = new FormData();

    formData.append('file', file);

    const req = new HttpRequest('POST', `${this.rootURL}/salaries/import`, formData, {
      reportProgress: true,
      responseType: 'json'
    });

    return this.http.request(req);
  }
}
