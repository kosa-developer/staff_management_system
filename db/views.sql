create view  question_performance as  select staff_answer.Staff_Id,staff_answer.Question_Id, count(staff_answer.Answer_Id) as Correct_answer,policy_questions.Marks as Marks,(count(staff_answer.Answer_Id)*policy_questions.Marks) as Performance from staff,policy_questions,policy_answers,staff_answer where staff_answer.Staff_Id=staff.Staff_Id and staff_answer.Answer_Id=policy_answers.Answer_Id
 and staff_answer.Question_Id=policy_questions.Question_Id and staff_answer.Question_Id=policy_answers.Question_Id and policy_answers.Correct=1 group by staff_answer.Question_Id,staff.Staff_Id;

create view  staff_performance as select question_performance.Staff_Id,staff.Staff_Name,sum(question_performance.Performance) as Staff_Performance from staff,question_performance where question_performance.Staff_Id=staff.Staff_Id;

 create view total_correct_answer as select policy_questions.Question_Id,policy_questions.Marks as Marks,count(policy_answers.Answer_Id) as Correct_Answers,(count(policy_answers.Answer_Id)*policy_questions.Marks) as Total_Marks from policy_questions,policy_answers where 
 policy_questions.Question_Id=policy_answers.Question_Id and policy_answers.Correct=1 group by policy_answers.Question_Id;
