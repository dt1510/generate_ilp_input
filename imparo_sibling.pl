%imparo, sibling
head_modes([brother(+person,+person),parent(+person,+person)]).
body_modes([sibling(+person),male(+person),father(+person)]).
%type information
person(X).

%file%imb
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

%file%imx
%positive examples
brother(bart,lisa).
brother(rod,todd).

%negative examples
:-brother(lisa,bart).
:-brother(rod,bart).
:-parent(lisa,bart).


