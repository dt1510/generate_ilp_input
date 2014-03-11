%toplog, sibling

:-modeh(brother(+person,+person)).
:-modeh(parent(+person,+person)).
:-modeb(sibling(+person)).
:-modeb(male(+person)).
:-modeb(father(+person)).


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
example(brother(bart,lisa),1).
example(brother(rod,todd),1).

%negative examples
example(brother(lisa,bart),-1).
example(brother(rod,bart),-1).
example(parent(lisa,bart),-1).


