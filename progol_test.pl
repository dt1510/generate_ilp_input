%test
:- set(i,2), set(h,20), set(c,2)?
:-modeh(*, woman(+person))?
:-modeb(*, female(+person))?
:-modeb(*, male(+person))?

:-determination(woman/1, female/1)?
:-determination(woman/1, male/1)?

%type information
person(adam).
person(bob).
person(alice).
person(mary).

%background knowledge
male(adam).
male(bob).
female(alice).
female(mary).

%positive examples
woman(alice).
woman(mary).

%negative examples
:-woman(adam).

