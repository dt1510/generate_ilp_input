dynamic brother/2, parent/2.

modeh(brother(+person,+person)).
modeh(parent(+person,+person)).
modeb(sibling(+person,+person)).
modeb(male(+person)).
modeb(father(+person,+person)).

determination(brother/2, sibling/2).
determination(brother/2, male/1).
determination(parent/2, father/2).

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

male(bart2).
male(rod2).
male(todd2).
parent(homer2,bart2).
parent(homer2,maggie2).
father(ned2,rod2).
father(ned2,todd2).
father(homer2,lisa2).

male(bart3).
male(rod3).
male(todd3).
parent(homer3,bart3).
parent(homer3,maggie3).
father(ned3,rod3).
father(ned3,todd3).
father(homer3,lisa3).
sibling(X,Y):-parent(Z,X),parent(Z,Y).

%positive examples
brother(bart,lisa).
brother(rod,todd).
brother(bart2,lisa2).
brother(rod2,todd2).
brother(bart3,lisa3).
brother(rod3,todd3).

%negative examples
brother(lisa,bart).
brother(rod,bart).
brother(maggie, maggie).
parent(lisa,bart).
