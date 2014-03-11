%imparo, test
head_modes([woman(+person)]).
body_modes([female(+person),male(+person)]).
%type information
person(adam).
person(bob).
person(alice).
person(mary).

%file%imb
%background knowledge
male(adam).
male(bob).
female(alice).
female(mary).
female(susan).

%file%imx
%positive examples
woman(alice).
woman(mary).
woman(susan).

%negative examples
:-woman(adam).

