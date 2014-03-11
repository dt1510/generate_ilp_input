%progol, sibling
:- set(i,2), set(h,20), set(c,2)?

:-modeh(*,brother(+person,+person))?
:-modeh(*,parent(+person,+person))?
:-modeb(*,sibling(+person))?
:-modeb(*,male(+person))?
:-modeb(*,father(+person))?

:-determination(brother/2, sibling/2)?
:-determination(brother/2, male/1)?
:-determination(parent/2, father/2)?

%type information
person(X).

%background knowledge
male(bart).
male(rod).
male(todd).
parent(homer,bart).
parent(homer,maggie).
father(ned,rod).
father(ned,todd).
father(homer,lisa).
sibling(X,Y):-parent(Z,X),parent(Z,Y).

%positive examples
brother(bart,lisa).
brother(rod,todd).

%negative examples
:-brother(lisa,bart).
:-brother(rod,bart).
:-parent(lisa,bart).


